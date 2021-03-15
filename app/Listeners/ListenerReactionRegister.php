<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use App\Events\EventReactionRegister;
use App\Jobs\JobReaction;
use Carbon\Carbon;

class ListenerReactionRegister
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    protected $maxPage = 5;
    protected $maxIds = 3;

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EventReactionRegister $event)
    {
        $friends = [];

        if ($event->user->reaction->only_friends) {
            $response = Http::withHeaders([
                "user-agent" => "Dalvik/1.6.0 (Linux; U; Android 4.4.2; NX55 Build/KOT5506) [FBAN/FB4A;FBAV/106.0.0.26.68;FBBV/45904160;FBDM/{density=3.0,width=1080,height=1920};FBLC/it_IT;FBRV/45904160;FBCR/PosteMobile;FBMF/asus;FBBD/asus;FBPN/com.facebook.katana;FBDV/ASUS_Z00AD;FBSV/5.0;FBOP/1;FBCA/x86:armeabi-v7a;]"
            ])->get("https://graph.facebook.com/me/friends", ["access_token" => $event->user->fb_access_token]);

            $body = $response->json();
            if (! empty($body["error"])) {
                return $this->failedResponse($event);
            }
    
            $friends = collect($body["data"])->pluck("id")->toArray();
        }

        $link = "/home.php";
        $arrayPostIds = [];

        for ($i = 0; $i < $this->maxPage; $i++) {
            if (empty($link)) {
                break;
            }

            $response = Http::withHeaders(["cookie" => $event->user->fb_cookie])->get($link);
    
            $body = $response->body();
            
            if (strpos($body, "login_form") !== false) {
                return $this->failedResponse($event);
            }

            $dom = new \DOMDocument;
            @$dom->loadHTML($body);
    
            foreach ($dom->getElementsByTagName("a") as $el) {
                $href = urldecode($el->getAttribute("href"));
                if (preg_match("/\:top_level_post_id.(\d+):content_owner_id_new.(\d+)/", $href, $matches)) {
                    if (! in_array($matches[1], $arrayPostIds)) {
                        if (!$event->user->reaction->only_friends) {
                           $arrayPostIds[] = $matches[1];
                           continue;
                        }
    
                        if (in_array($matches[2], $friends)) {
                            $arrayPostIds[] = $matches[1];
                            continue;
                        }
                    }
                }
            }
            
            if (count($arrayPostIds) >= $this->maxIds) {
                break;
            }
            
            $link = null;
            
            foreach ($dom->getElementsByTagName("a") as $el) {
                $href = $el->getAttribute("href");
                if (strpos($href, "stories.php?aftercursorr=") !== false) {
                    $link = $href;
                    break;
                }
            }
        }

        foreach (array_slice($arrayPostIds, 0, $this->maxIds) as $ids) {
            $jobs = (new JobReaction($event->user, $ids))
                ->delay(Carbon::now()->addSeconds(5));

            dispatch($jobs);
        }
    }
    
    protected function failedResponse($event)
    {
        $event->user->reaction->withoutEvents(function() use ($event) {
            $reaction = $event->user->reaction;
            $reaction->is_active = 0;
            return $reaction->save();
        });

        activity("bot")
            ->causedBy($event->user)
            ->withProperties(["name" => "reactions"])
            ->log("Bot Reaction di Nonaktifkan karena cookie mati.");
    }
}

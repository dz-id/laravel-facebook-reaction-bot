<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use App\Events\EventReaction;

class ListenerReaction
{
    /**
     * Create the event listener.
     *
     * @return void
     */
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
    public function handle(EventReaction $event)
    {
        $user = $event->user;

        $headers = ["cookie" => $user->fb_cookie];

        $response = Http::withHeaders($headers)->get("/reactions/picker/", [
            "is_permalink" => 1,
            "ft_id"        => $event->postID
        ]);

        $body = $response->body();

        if (strpos($body, "login_form") !== false) {
            return;
        }

        $arrayReactionType = config("bot.reaction_type");

        if ($user->reaction->type === "random") {
            unset($arrayReactionType["random"]);
            $type = $arrayReactionType[array_rand($arrayReactionType)]["id"];
        } else {
            $type = $arrayReactionType[$user->reaction->type]["id"];
        }

        $link = null;

        $dom = new \DOMDocument;
        @$dom->loadHTML($body);

        foreach ($dom->getElementsByTagName("a") as $el) {
            $href = $el->getAttribute("href");
            if (strpos($href, "reaction_type=" . $type)) {
                $link = $href;
                break;
            }
        }

        if (empty($link)) {
            return;
        }

        Http::withHeaders($headers)->get($link);
    }
}

<?php

namespace App\Observers;

use App\Models\Reaction;

class ObserverReaction
{
    /**
     * Handle the Reaction "created" event.
     *
     * @param  \App\Models\Reaction  $reaction
     * @return void
     */
    public function created(Reaction $reaction)
    {
        activity("bot")
            ->causedBy($reaction->user)
            ->withProperties(["name" => "reactions"])
            ->log("Install Bot Reaction " . config("bot.reaction_type")[$reaction->type]["name"]);
    }

    /**
     * Handle the Reaction "updated" event.
     *
     * @param  \App\Models\Reaction  $reaction
     * @return void
     */

    public function updated(Reaction $reaction)
    {
        $type = config("bot.reaction_type");

        if ($reaction->isDirty("type")) {
            $old = $reaction->getOriginal("type");
            
            $message = "Mengubah Reaction Type " . $type[$old]["name"] . " Ke " . $type[$reaction->type]["name"];

            activity("bot")
                ->causedBy($reaction->user)
                ->withProperties(["name" => "reactions"])
                ->log($message);
        }

        if ($reaction->isDirty("only_friends")) {
            $old = $reaction->getOriginal("only_friends");

            if ($old) {
                $message = "Mengubah Reaction hanya postingan Teman ke semua postingan";
            } else {
                $message = "Mengubah Reaction hanya ke postingan Teman";
            }

            activity("bot")
                ->causedBy($reaction->user)
                ->withProperties(["name" => "reactions"])
                ->log($message);
        }
        
        if ($reaction->isDirty("is_active")) {
            $old = $reaction->getOriginal("is_active");

            if ($old) {
                $message = "Menonaktifkan Bot Reaction";
            } else {
                $message = "Mengaktifkan Bot Reaction";
            }

            activity("bot")
                ->causedBy($reaction->user)
                ->withProperties(["name" => "reactions"])
                ->log($message);
        }
    }

    /**
     * Handle the Reaction "deleted" event.
     *
     * @param  \App\Models\Reaction  $reaction
     * @return void
     */
    public function deleted(Reaction $reaction)
    {
        activity("bot")
            ->causedBy($reaction->user)
            ->withProperties(["name" => "reactions"])
            ->log("Menghapus Bot Reaction");
    }

    /**
     * Handle the Reaction "restored" event.
     *
     * @param  \App\Models\Reaction  $reaction
     * @return void
     */
    public function restored(Reaction $reaction)
    {
        //
    }

    /**
     * Handle the Reaction "force deleted" event.
     *
     * @param  \App\Models\Reaction  $reaction
     * @return void
     */
    public function forceDeleted(Reaction $reaction)
    {
        //
    }
}

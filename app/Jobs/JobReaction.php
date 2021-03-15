<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Events\EventReaction;

class JobReaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
   
    protected $user, $postID;

    public function __construct(User $user, string $postID)
    {
        $this->user = $user;
        $this->postID = $postID;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
        event(new EventReaction($this->user, $this->postID));
    }
}

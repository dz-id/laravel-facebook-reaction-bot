<?php

namespace App\Console\Commands\Bot;

use Illuminate\Console\Command;
use App\Models\User;
use App\Jobs\JobReactionRegister;

class CommandRegister extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mendaftarkan semua user yang menggunakan bot ke dalam Jobs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = User::with("reaction")->whereHas("reaction", function($builder) {
            $builder->where("is_active", 1);
        })->get();

        foreach ($data as $user) {
            dispatch(new JobReactionRegister($user));
        }

        $this->info("[" . $data->count() . "] User Berhasil didaftarkan kedalam Jobs");
    }
}

<?php

namespace App\Console\Commands\Bot;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Artisan;

class CommandRun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:run
                            {--delay-minute=5 : Delay dalam menit}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menjalankan semua Bot yang terdaftar dalam Jobs';

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
        $timeDelay = Carbon::now()->timestamp;
        
        $a = function(string $text, int $max = 1) {
            $clone = [];
            for ($i = 0; $i < $max; $i++) {
                $clone[] = $text;
            }
            
            return $clone;
        };

        $animateArray = [$a("|", 500), $a("/", 500), $a("-", 500), $a("\\", 500)];

        while (true) {
            if ($timeDelay < Carbon::now()->timestamp) {
                Artisan::call("bot:register");
                
                $delay = $this->option("delay-minute") ?: 5;

                $timeDelay = Carbon::now()->addMinutes($delay)->timestamp;
            }

            foreach ($animateArray as $animate) {
                foreach ($animate as $text) {
                    $time = Carbon::now()->format("H:i:s");
                    $this->output->write("\r[" . $time . "] Bot sedang berjalan, jangan ditutup.... (" . $text . ")");
                }
            }
        }
    }
}

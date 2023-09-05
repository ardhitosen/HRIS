<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Timeoff;

class TimeoffExpirationCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:timeoff-expiration-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $timeoffs = Timeoff::all();

        foreach ($timeoffs as $timeoff) {
            $setDate = $timeoff->expiration_date;
            $currentDate = now();

            if ($currentDate > $setDate) {
                $timeoff->status = "Expired";
                $timeoff->save();
            }
        }
    }
}

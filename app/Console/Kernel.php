<?php

namespace App\Console;

use App\Mail\NotifyStudentBookReturn;
use App\Models\Transaction;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function(){
            $transactions = Transaction::with('user','book')->where('status', '=', 'released')->whereDate('release_date', now())->get();
            
            $transactions->each(function($transaction){
                Mail::to($transaction->user)->send(
                    new NotifyStudentBookReturn($transaction)
                );
                $transaction->status = 'to return';
                $transaction->save();
            });

        })->daily()->timezone('Asia/Singapore')->at(env('TIME_PASS'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

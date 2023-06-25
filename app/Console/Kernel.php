<?php

namespace App\Console;

use App\Mail\NotifyStudentBookReturn;
use App\Models\Transaction;
use Carbon\Carbon;
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

        // AUTOMATION OF NOTIFYING STUDENT TO RETURN THE BOOK
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


        //AUTOMATION OF DELETING UNPICKED UP BOOK TRANSACTION
        $schedule->call(function(){
            $timeAlloted = env('TIME_ALLOTED');
            $transaction = Transaction::with('book')->where('status', '=', 'to release')->whereDate('created_at', now())->get();

            $transaction->each(function($item) use($timeAlloted) {

                $createdAtHours = $item->created_at->addHours($timeAlloted)->format('H:i:s');
                
                    $result = Carbon::now()->greaterThanOrEqualTo($createdAtHours);

                    if($result){
                        $item->book->status = NULL;
                        $item->book->save();
                        $item->delete();

                    }

            }); 

        })->everyMinute();
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

<?php

namespace App\Jobs;

use App\Item;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use DateTime;

class ProcessStockReset implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $now = new DateTime('now');
        $nowMonth = $now->format('n');
        
        $items = Item::get();
        
        foreach($items as $item) {
            if($nowMonth == $item->stock_reset_month) {
                $item->stock = $item->stock_reset_count;
                $item->save();
            }
        }
    }
    
}


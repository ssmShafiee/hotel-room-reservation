<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Carbon\Carbon;

class ExpireReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'منقضی کردن رزروهای منقضی شده';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredCount = Reservation::where('status', 'active')
            ->where('expires_at', '<', now())
            ->update(['status' => 'expired']);

        $this->info("تعداد {$expiredCount} رزرو منقضی شد.");
    }
}

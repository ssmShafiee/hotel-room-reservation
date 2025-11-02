<?php


namespace App\Repositories;

use App\Models\Reservation;
use App\Repositories\Interfaces\ReservationRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ReservationRepository implements ReservationRepositoryInterface
{
    public function findActiveByRoomId(int $roomId)
    {
        return Reservation::where('room_id', $roomId)
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->first();
    }

    public function create(array $data)
    {
        return Reservation::create($data);
    }

    public function expireOldReservations(): int
    {
        return Reservation::where('status', 'active')
            ->where('expires_at', '<', now())
            ->update(['status' => 'expired']);
    }
}

<?php

namespace App\Services;

use App\Models\Room;
use App\Repositories\Interfaces\ReservationRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    protected $repository;

    public function __construct(ReservationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function reserveRoom(int $roomId)
    {
        //preventing from overselling
        return DB::transaction(function () use ($roomId) {
            $room = Room::lockForUpdate()->find($roomId);
            if (!$room) {
                throw new \Exception('اتاق وجود ندارد.');
            }

            $active = $this->repository->findActiveByRoomId($room->id);
            if ($active) {
                throw new \Exception('این اتاق در حال حاضر رزرو شده است.');
            }

            return $this->repository->create([
                'room_id' => $room->id,
                'reserved_at' => now(),
                'expires_at' => now()->addMinutes(2),
                'status' => 'active',
            ]);
        });
    }

    public function expireOldReservations(): int
    {
        return $this->repository->expireOldReservations();
    }
}

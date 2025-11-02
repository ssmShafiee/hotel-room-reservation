<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Services\ReservationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;

class ReservationController extends Controller
{

    protected $service;

    public function __construct(ReservationService $service)
    {
        $this->service = $service;
    }

    /**
     * temp reservation
     */
    public function reserve(Request $request)
    {
        $validator = Validator::make(
            $request->only('room_id'),
            [
                'room_id' => 'required|exists:rooms,id',
            ],
            [
                'room_id.required' => 'شناسه اتاق الزامی است.',
                'room_id.exists' => 'این اتاق وجود ندارد.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        try {
            $reservation = $this->service->reserveRoom($request->room_id);
            return response()->json([
                'message' => 'رزرو با موفقیت انجام شد.',
                'reservation' => $reservation,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    /**
     * get rooms
     */
    public function rooms()
    {
        $rooms = Room::with(['reservations' => function ($query) {
            $query->where('status', 'active')
                ->where('expires_at', '>', now());
        }])->get();

        $rooms = $rooms->map(function ($room) {
            $room->is_reserved = $room->reservations->isNotEmpty();
            unset($room->reservations);
            return $room;
        });

        return response()->json($rooms);
    }

    /**
     * expiring reservation after 2 min
     */
    public function expireOldReservations()
    {
        $expired = $this->service->expireOldReservations();

        return response()->json([
            'message' => "تعداد {$expired} رزرو منقضی شد.",
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'room_id',
        'reserved_at',
        'expires_at',
        'status',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}

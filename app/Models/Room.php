<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'floor',
        'door_number',
        'type',
        'area',
        'room_amount',
        'bed_amount',
        'children_bed_amount',
        'price',
        'status',
    ];

    public function bookings(){
        return $this->hasMany(Booking::class, 'room_id');
    }

    public function room_properties()
    {
        return $this->belongsToMany(RoomProperty::class,'rooms_room_properties');
    }

    public function cleaning_logs(){
        return $this->hasMany(CleaningLog::class, 'room_id');
    }
}

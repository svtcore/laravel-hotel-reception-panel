<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'floor_number',
        'room_number',
        'type',
        'total_rooms',
        'adults_beds_count',
        'children_beds_count',
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
}

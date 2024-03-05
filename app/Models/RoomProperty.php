<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomProperty extends Model
{
    use HasFactory;

    public function rooms()
    {
        return $this->belongsToMany(Room::class,'rooms_room_properties');
    }
}

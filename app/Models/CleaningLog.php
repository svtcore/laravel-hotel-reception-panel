<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CleaningLog extends Model
{
    use HasFactory;

    public function rooms(){
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function staff(){
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}

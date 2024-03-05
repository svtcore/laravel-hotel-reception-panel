<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestDocument extends Model
{
    use HasFactory;

    public function guest(){
        return $this->belongsTo(Guest::class, 'guest_id');
    }
}

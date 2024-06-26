<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'dob',
        'gender'
    ];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class,'guests_bookings');
    }

    public function guest_document(){
        return $this->hasOne(GuestDocument::class, 'guest_id');
    }
}

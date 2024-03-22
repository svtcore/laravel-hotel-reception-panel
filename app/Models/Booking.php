<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'adult_amount',
        'children_amount',
        'total_cost',
        'payment_type',
        'check_in_date',
        'check_out_date',
        'note',
        'status',
    ];

    public function additional_services(){
        return $this->belongsToMany(AdditionalService::class, 'additional_services_bookings');
    }

    public function guests(){
        return $this->belongsToMany(Guest::class, 'guests_bookings');
    }

    public function rooms(){
        return $this->belongsTo(Room::class, 'room_id');
    }
}

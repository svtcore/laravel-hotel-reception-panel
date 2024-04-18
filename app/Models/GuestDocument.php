<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_country',
        'document_serial',
        'document_number',
        'document_expired',
        'document_issued_by',
        'document_issued_date',
    ];

    public function guest(){
        return $this->belongsTo(Guest::class, 'guest_id');
    }
}

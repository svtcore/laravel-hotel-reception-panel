<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    public function cleaning_logs(){
        return $this->hasMany(CleaningLog::class, 'staff_id');
    }
}

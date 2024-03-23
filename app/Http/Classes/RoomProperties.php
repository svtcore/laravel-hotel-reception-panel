<?php

namespace App\Http\Classes;

use Exception;
use App\Models\RoomProperty;

class RoomProperties
{
    public function getAll():?iterable
    {
        try{
            $room_properties = RoomProperty::all();
            if ($room_properties->count() > 0) {
                return $room_properties;
            } else {
                return null;
            }
        }
        catch(Exception $e){
            return null;
        }
    }
}

?>
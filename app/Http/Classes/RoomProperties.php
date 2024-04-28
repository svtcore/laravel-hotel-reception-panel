<?php

namespace App\Http\Classes;

use Exception;
use App\Models\RoomProperty;

class RoomProperties
{

    /**
     * Retrieves all room properties.
     *
     * @return iterable|null A collection of room properties if found, otherwise null.
     */
    public function getAll(): ?iterable
    {
        try {
            $room_properties = RoomProperty::all();
            if ($room_properties->count() > 0) {
                return $room_properties;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }
}

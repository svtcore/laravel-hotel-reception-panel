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
            $room_properties = RoomProperty::orderBy('name')->get();
            if ($room_properties->count() > 0) {
                return $room_properties;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    public function store($inputData): bool
    {
        try {
            $room_properties = RoomProperty::create([
                'name' => $inputData['name'],
                'available' => $inputData['status'],
            ]);
            if ($room_properties) return true;
            else return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function update($inputData, int $id): bool
    {
        try {
            $room_properties = RoomProperty::findOrFail($id);
            $result = $room_properties->update([
                'name' => $inputData['name'],
                'available' => $inputData['status'],
            ]);
            if ($result) return true;
            else return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function destory(int $id): bool
    {
        try {
            $room_properties = RoomProperty::findOrFail($id);
            $room_properties->rooms()->detach();
            $room_properties->delete();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getById(int $id): ?object
    {
        try {
            $room_properties = RoomProperty::where('id', $id)->first();
            if ($room_properties) {
                return $room_properties;
            } else return null;
        } catch (Exception $e) {
            return null;
        }
    }
}

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

    /**
     * Stores a new room property.
     *
     * @param array $inputData Data for creating the room property, including 'name' and 'status'.
     * @return bool True if the room property was successfully created, otherwise false.
     */
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

    /**
     * Updates an existing room property by ID.
     *
     * @param array $inputData Data for updating the room property, including 'name' and 'status'.
     * @param int $id The ID of the room property to update.
     * @return bool True if the room property was successfully updated, otherwise false.
     */
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

    /**
     * Deletes a room property by ID.
     *
     * @param int $id The ID of the room property to delete.
     * @return bool True if the room property was successfully deleted, otherwise false.
     */
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

    /**
     * Retrieves a room property by ID.
     *
     * @param int $id The ID of the room property to retrieve.
     * @return object|null The room property object if found, otherwise null.
     */
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

<?php

namespace App\Http\Classes;


use Exception;
use Illuminate\Support\Carbon;
use App\Models\Room;
use PhpParser\Node\Expr;
use App\Http\Classes\Bookings;
use App\Models\Booking;

class Rooms
{
    /**
     * Retrieves all available rooms.
     *
     * @return iterable|null A collection of available rooms if found, otherwise null.
     */
    public function getFree(): ?iterable
    {
        try {
            $rooms = Room::where('status', 'available')->get();
            if ($rooms->count() > 0) {
                return $rooms;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Retrieves a room by its ID.
     *
     * @param int $id The ID of the room to retrieve.
     * @param bool $trashed Flag indicating whether to include trashed rooms.
     * @return object|null The room object if found, otherwise null.
     */
    public function getById($id, $trashed): ?object
    {
        try {
            if ($trashed)
                $room = Room::with('room_properties')->where('id', $id)->withTrashed()->first();
            else
                $room = Room::with('room_properties')->where('id', $id)->first();
            return $room !== null ? $room : null;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Searches for rooms based on various parameters.
     *
     * @param array $inputData An array containing search parameters.
     * @param bool $trashed Flag indicating whether to include trashed rooms.
     * @return iterable|null A collection of rooms matching the search criteria, or null if no rooms found.
     */
    public function searchByParams($inputData, $trashed): mixed
    {
        try {
            $roomNumber = $inputData['roomNumber'] ?? null;
            $guestName = $inputData['guestName'] ?? null;
            $startDate = $inputData['startDate'] ?? null;
            $endDate = $inputData['endDate'] ?? null;
            $roomType = $inputData['type'] ?? null;
            $roomStatus = $inputData['status'] ?? null;
            $roomAdult = $inputData['adultsBedsCount'] ?? null;
            $roomChildren = $inputData['childrenBedsCount'] ?? null;
            $properties = $inputData['additionalProperties'] ?? null;
            $firstName = null;
            $lastName = null;

            if ($roomNumber != null) {
                if ($trashed)
                    $rooms = Room::with('bookings')->with('room_properties')->where('room_number', $roomNumber)->withTrashed()->get();
                else
                    $rooms = Room::with('bookings')->with('room_properties')->where('room_number', $roomNumber)->get();
            } elseif ($guestName != null) {
                [$firstName, $lastName] = explode(' ', $inputData['guestName']);
                $rooms = Room::with('bookings')->whereHas('bookings.guests', function ($query) use ($firstName, $lastName) {
                    $query->where('first_name', $firstName)
                        ->where('last_name', $lastName);
                })->with('room_properties')->get();
            } elseif ($roomStatus == "available") {
                $startDate = $startDate . " 00:00:00";
                $endDate = $endDate . " 23:59:59";

                //search free rooms which occupied but will free inside in specific date range
                $occupiedRooms = Room::with('bookings')
                    ->whereIn('status', ['occupied'])
                    ->where(function ($query) use ($roomType, $roomAdult, $roomChildren) {
                        if ($roomType != "0") {
                            $query->where('type', $roomType);
                        }
                        if ($roomAdult != "0") {
                            $query->where('adults_beds_count', $roomAdult);
                        }
                        if ($roomChildren != "-1") {
                            $query->where('children_beds_count', $roomChildren);
                        }
                    })
                    ->when(!empty($properties), function ($query) use ($properties) {
                        $query->whereHas('room_properties', function ($subQuery) use ($properties) {
                            $subQuery->whereIn('id', $properties);
                        });
                    })
                    ->where(function ($query) use ($startDate, $endDate) {
                        if (!empty($startDate) && !empty($endDate)) {
                            $query->whereHas('bookings', function ($dateQuery) use ($startDate, $endDate) {
                                $dateQuery->where('check_in_date', '>=', $startDate)
                                    ->where('check_out_date', '<=', $endDate)
                                    ->whereIn('status', ['reserved', 'active', 'expired']);
                            });
                        }
                    });

                $availableRooms = Room::whereIn('status', ['available'])
                    ->where(function ($query) use ($roomType, $roomAdult, $roomChildren) {
                        if ($roomType != "0") {
                            $query->where('type', $roomType);
                        }
                        if ($roomAdult != "0") {
                            $query->where('adults_beds_count', $roomAdult);
                        }
                        if ($roomChildren != "-1") {
                            $query->where('children_beds_count', $roomChildren);
                        }
                    })
                    ->when(!empty($properties), function ($query) use ($properties) {
                        $query->whereHas('room_properties', function ($subQuery) use ($properties) {
                            $subQuery->whereIn('id', $properties);
                        });
                    })
                    ->whereDoesntHave('bookings');

                $rooms = $occupiedRooms->union($availableRooms)->get();
            } elseif ($roomStatus == "occupied") {
                $startDate = $startDate . " 00:00:00";
                $endDate = $endDate . " 23:59:59";

                $rooms = Room::with('bookings')
                    ->whereIn('status', ['occupied'])
                    ->where(function ($query) use ($roomType, $roomAdult, $roomChildren) {
                        if ($roomType != "0") {
                            $query->where('type', $roomType);
                        }
                        if ($roomAdult != "0") {
                            $query->where('adults_beds_count', $roomAdult);
                        }
                        if ($roomChildren != "-1") {
                            $query->where('children_beds_count', $roomChildren);
                        }
                    })
                    ->when(!empty($properties), function ($query) use ($properties) {
                        $query->whereHas('room_properties', function ($subQuery) use ($properties) {
                            $subQuery->whereIn('id', $properties);
                        });
                    })
                    ->where(function ($query) use ($startDate, $endDate) {
                        if (!empty($startDate) && !empty($endDate)) {
                            $query->whereHas('bookings', function ($dateQuery) use ($startDate, $endDate) {
                                $dateQuery->where('check_in_date', '>=', $startDate)
                                    ->where('check_out_date', '<=', $endDate);
                            });
                        }
                    })->get();
            } else if ($roomStatus != "available" || $roomStatus != "occupied") {
                $rooms = Room::where(function ($query) use ($roomType, $roomAdult, $roomChildren, $roomStatus) {
                    if ($roomType != "0")
                        $query->where('type', $roomType);
                    if ($roomAdult != "0")
                        $query->where('adults_beds_count', $roomAdult);
                    if ($roomChildren != "-1")
                        $query->where('children_beds_count', $roomChildren);
                    if ($roomStatus != "0")
                        $query->where('status', $roomStatus);
                })
                ->when(!empty($properties), function ($query) use ($properties) {
                    $query->whereHas('room_properties', function ($subQuery) use ($properties) {
                        $subQuery->whereIn('id', $properties);
                    });
                })->get();
                //for maintenence no date required
            }
            if ($rooms->count() > 0) {
                return $rooms;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Stores a new room record in the database.
     *
     * @param array $inputData An array containing room data to be stored.
     * @return bool|int The ID of the newly created room if successful, otherwise false.
     */
    public function store($inputData): bool|int
    {
        try {
            $room = Room::create([
                'floor_number' => $inputData['floorNumber'],
                'room_number' => $inputData['roomNumber'],
                'type' => $inputData['type'],
                'total_rooms' => $inputData['totalRooms'],
                'adults_beds_count' => $inputData['adultsBedsCount'],
                'children_beds_count' => $inputData['childrenBedsCount'],
                'price' => $inputData['price'],
                'status' => $inputData['status'],
            ]);

            if ($room && isset($inputData['additionalProperties'])) {
                $room->room_properties()->attach($inputData['additionalProperties']);
            }

            return $room->id ?? false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Updates an existing room record in the database.
     *
     * @param array $inputData An array containing room data to be updated.
     * @param int $id The ID of the room to be updated.
     * @return bool|null True if the update was successful, otherwise false or null.
     */
    public function update($inputData, $id): ?bool
    {
        try {
            $room = Room::findOrFail($id);
            $result = $room->update([
                'floor_number' => $inputData['floorNumber'],
                'room_number' => $inputData['roomNumber'],
                'type' => $inputData['type'],
                'total_rooms' => $inputData['totalRooms'],
                'adults_beds_count' => $inputData['adultsBedsCount'],
                'children_beds_count' => $inputData['childrenBedsCount'],
                'price' => $inputData['price'],
                'status' => $inputData['status'],
            ]);
            if (isset($inputData['additionalProperties'])) {
                $room->room_properties()->detach();
                $room->room_properties()->attach($inputData['additionalProperties']);
            }
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Deletes a room record from the database by its ID.
     *
     * @param int $id The ID of the room to be deleted.
     * @return bool True if the deletion was successful, otherwise false.
     */
    public function deleteById($id): bool
    {
        try {
            $room = Room::findOrFail($id);
            $result = $room->delete();
            return $result ? true : false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retrieves the count of available and occupied rooms.
     *
     * @return array|null An array containing the count of occupied and available rooms. 
     *                   The first element is the count of occupied rooms, 
     *                   and the second element is the count of available rooms.
     *                   Returns null in case of an exception.
     */
    public function getRoomsAvailabilityCount()
    {
        try {
            $rooms = Room::all();

            $available = $rooms->where('status', 'available')->count() ?? 0;
            $occupied = $rooms->where('status', 'occupied')->count() ?? 0;

            return [$occupied, $available];
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Retrieves demand for various room types.
     *
     * @return array An array containing demand for different room types.
     *               The keys of the array represent room types, and the values represent the number of bookings for each type.
     */
    public function getRoomTypesDemand(): array
    {
        try {
            $roomTypeCounts = Booking::whereIn('status', ['active', 'completed', 'expired'])
                ->withCount(['rooms as standard_count' => function ($query) {
                    $query->where('type', 'standard');
                }])
                ->withCount(['rooms as deluxe_count' => function ($query) {
                    $query->where('type', 'deluxe');
                }])
                ->withCount(['rooms as suite_count' => function ($query) {
                    $query->where('type', 'suite');
                }])
                ->withCount(['rooms as penthouse_count' => function ($query) {
                    $query->where('type', 'penthouse');
                }])
                ->get();

            $roomTypeDemand = [
                'standard' => $roomTypeCounts->sum('standard_count'),
                'deluxe' => $roomTypeCounts->sum('deluxe_count'),
                'suite' => $roomTypeCounts->sum('suite_count'),
                'penthouse' => $roomTypeCounts->sum('penthouse_count')
            ];

            return $roomTypeDemand;
        } catch (Exception $e) {
            return array();
        }
    }

    /**
     * Changes the status of a room based on the new booking status.
     *
     * @param int $room_id The ID of the room whose status is being updated.
     * @param string $new_status The new status of the booking.
     *                           Possible values are: "reserved", "active", "deleted", or any other status.
     * @return bool True if the room status was successfully updated; otherwise, false.
     */
    public function changeRoomStatusByBookingStatus($room_id, $new_status)
    {
        $room = Room::findOrFail($room_id);
        if ($new_status == "reserved" || $new_status == "active") {
            $result = $room->update(["status" => "occupied"]);
            if ($result) return true;
            else return false;
        } elseif ($new_status == "deleted") {
            //case when booking is deleted
            //checking if exist available reserved booking then mark room like occupied otherwise mark like available
            $result = Booking::where('room_id', $room_id)->whereIn('status', ['reserved', 'active']);
            if ($result && $result->count() > 0) {
                $result = $room->update(["status" => "occupied"]);
            } else $result = $room->update(["status" => "available"]);
            if ($result) return true;
            else return false;
        } else {
            $result = $room->update(["status" => "available"]);
            if ($result) return true;
            else return false;
        }
    }
}

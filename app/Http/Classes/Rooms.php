<?php

namespace App\Http\Classes;


use Exception;
use Illuminate\Support\Carbon;
use App\Models\Room;
use PhpParser\Node\Expr;
use App\Http\Classes\Bookings;

class Rooms
{


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

                $rooms = Room::with('bookings')
                    ->whereIn('status', ['occupied', 'available'])
                    ->where(function ($query) use ($roomType, $roomAdult, $roomChildren, $startDate, $endDate) {
                        if ($roomType != "0")
                            $query->where('type', $roomType);
                        if ($roomAdult != "0")
                            $query->where('adults_beds_count', $roomAdult);
                        if ($roomChildren != "-1") {
                            $query->where('children_beds_count', $roomChildren);
                        }
                    })
                    ->where(function ($subQuery) use ($properties) {
                        if (!empty($properties)) {
                            $subQuery->whereHas('room_properties', function ($doubleSubQuery) use ($properties) {
                                $doubleSubQuery->whereIn('id', $properties);
                            });
                        }
                    })
                    ->whereDoesntHave('bookings', function ($query) use ($startDate, $endDate) {
                        $query->where(function ($subQuery) use ($startDate, $endDate) {
                            $subQuery->where(function ($dateQuery) use ($startDate, $endDate) {
                                $dateQuery->where('check_in_date', '>=', $startDate)
                                    ->where('check_in_date', '<=', $endDate)
                                    ->whereIn('status', ['reserved', 'active', 'expired']);
                            })->orWhere(function ($dateQuery) use ($startDate, $endDate) {
                                $dateQuery->where('check_out_date', '>', $startDate)
                                    ->where('check_out_date', '<=', $endDate)
                                    ->whereIn('status', ['reserved', 'active', 'expired']);
                            })->orWhere(function ($dateQuery) use ($startDate, $endDate) {
                                $dateQuery->where('check_in_date', '<', $startDate)
                                    ->where('check_out_date', '>', $endDate)
                                    ->whereIn('status', ['reserved', 'active', 'expired']);
                            });
                        });
                    })->get();
            } elseif ($roomStatus == "occupied") {
                $startDate = $startDate . " 00:00:00";
                $endDate = $endDate . " 23:59:59";
                $rooms = Room::with('bookings')->where(function ($query) use ($roomType, $roomAdult, $roomChildren, $roomStatus) {
                    if ($roomType != "0")
                        $query->where('type', $roomType);
                    if ($roomAdult != "0")
                        $query->where('adults_beds_count', $roomAdult);
                    if ($roomChildren != "-1") {
                        $query->where('children_beds_count', $roomChildren);
                    }
                    if ($roomStatus != "0")
                        $query->where('status', $roomStatus);
                })
                    ->where(function ($subQuery) use ($properties) {
                        if (!empty($properties)) {
                            $subQuery->whereHas('room_properties', function ($doubleSubQuery) use ($properties) {
                                $doubleSubQuery->whereIn('id', $properties);
                            });
                        }
                    })
                    ->whereDoesntHave('bookings', function ($query) use ($startDate, $endDate) {
                        $query->where(function ($subQuery) use ($startDate, $endDate) {
                            $subQuery->where(function ($dateQuery) use ($startDate, $endDate) {
                                $dateQuery->where('check_in_date', '>=', $startDate)
                                    ->where('check_in_date', '<=', $endDate);
                            })->orWhere(function ($dateQuery) use ($startDate, $endDate) {
                                $dateQuery->where('check_out_date', '>', $startDate)
                                    ->where('check_out_date', '<=', $endDate);
                            })->orWhere(function ($dateQuery) use ($startDate, $endDate) {
                                $dateQuery->where('check_in_date', '<', $startDate)
                                    ->where('check_out_date', '>', $endDate);
                            });
                        });
                    })
                    ->get();
            } else if ($roomStatus != "available" || $roomStatus != "occupied") {
                $rooms = Room::where(function ($query) use ($roomType, $roomAdult, $roomChildren, $roomStatus) {
                    if ($roomType != "0")
                        $query->where('type', $roomType);
                    if ($roomAdult != "0")
                        $query->where('adults_beds_count', $roomAdult);
                    if ($roomChildren != "-1") {
                        $query->where('children_beds_count', $roomChildren);
                    }
                    if ($roomStatus != "0")
                        $query->where('status', $roomStatus);
                })
                ->where(function ($subQuery) use ($properties) {
                    if (!empty($properties)) {
                        $subQuery->whereHas('room_properties', function ($doubleSubQuery) use ($properties) {
                            $doubleSubQuery->whereIn('id', $properties);
                        });
                    }
                })->get();
                //for maintence no date required
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


    public function deleteById($id): bool
    {
        try {
            $room = Room::findOrFail($id);
            $result = $room->delete();
            return $result ? true : false;
        } catch (Exception $e) {
            dd($e);
        }
    }
}

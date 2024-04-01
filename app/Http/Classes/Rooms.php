<?php

namespace App\Http\Classes;


use Exception;
use Illuminate\Support\Carbon;
use App\Models\Room;
use PhpParser\Node\Expr;

class Rooms
{


    public function getFree(): ?iterable
    {
        try {
            $rooms = Room::where('status', 'free')->get();
            if ($rooms->count() > 0) {
                return $rooms;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    public function getById($id): ?object
    {
        try {
            $room = Room::findOrFail($id);
            return $room;
        } catch (Exception $e) {
            return null;
        }
    }

    public function searchByParams($inputData): mixed
    {
        try {
            $roomNumber = $inputData['roomNumber'] ?? null;
            $guestName = $inputData['guestName'] ?? null;
            $startDate = $inputData['startDate'] ?? null;
            $endDate = $inputData['endDate'] ?? null;
            $roomType = $inputData['roomType'] ?? null;
            $roomStatus = $inputData['roomStatus'] ?? null;
            $roomAdult = $inputData['roomAdult'] ?? null;
            $roomChildren = $inputData['roomChildren'] ?? null;
            $properties = $inputData['properties'] ?? null;
            $firstName = null;
            $lastName = null;

            if ($roomNumber != null) {
                $rooms = Room::with('bookings')->with('room_properties')->where('door_number', $roomNumber)->get();
            } elseif ($guestName != null) {
                [$firstName, $lastName] = explode(' ', $inputData['guestName']);
                $rooms = Room::with('bookings')->whereHas('bookings.guests', function ($query) use ($firstName, $lastName) {
                    $query->where('first_name', $firstName)
                        ->where('last_name', $lastName);
                })->with('room_properties')->get();
            } elseif ($roomStatus == "free") {
                $startDate = $startDate . " 00:00:00";
                $endDate = $endDate . " 23:59:59";
                //get busy rooms but free after input date booking will be over
                $rooms = Room::with('bookings')->where('status', 'busy')
                    ->where(function ($query) use ($roomType, $roomAdult, $roomChildren) {
                        if (!empty($roomType) && $roomType != 0)
                            $query->where('type', $roomType);
                        if (!empty($roomAdult) && $roomAdult != 0)
                            $query->where('bed_amount', $roomAdult);
                        if (!empty($roomChildren) && $roomChildren != -1)
                            $query->where('children_bed_amount', $roomChildren);
                    })
                    ->where(function ($subQuery) use ($properties) {
                        if (!empty($properties)) {
                            $subQuery->whereHas('room_properties', function ($doubleSubQuery) use ($properties) {
                                $doubleSubQuery->whereIn('id', $properties);
                            });
                        }
                    })
                    ->whereHas('bookings', function ($query) use ($startDate, $endDate) {
                        $query->where('check_out_date', '<=', $endDate)
                            ->where('check_out_date', '>=', $startDate)
                            ->where('status', 'active');
                    });
                    $freeRooms = Room::where('status', 'free')
                    ->where(function ($query) use ($roomType, $roomAdult, $roomChildren) {
                        if (!empty($roomType) && $roomType != 0)
                            $query->where('type', $roomType);
                        if (!empty($roomAdult) && $roomAdult != 0)
                            $query->where('bed_amount', $roomAdult);
                        if (!empty($roomChildren) && $roomChildren != -1)
                            $query->where('children_bed_amount', $roomChildren);
                    })
                    ->where(function ($subQuery) use ($properties) {
                        if (!empty($properties)) {
                            $subQuery->whereHas('room_properties', function ($doubleSubQuery) use ($properties) {
                                $doubleSubQuery->whereIn('id', $properties);
                            });
                        }
                    });
                $rooms = $rooms->union($freeRooms)->get();
            } elseif ($roomStatus == "busy") {
                $startDate = $startDate . " 00:00:00";
                $endDate = $endDate . " 23:59:59";
                $rooms = Room::with('bookings')->where(function ($query) use ($roomType, $roomAdult, $roomChildren, $roomStatus) {
                    if (!empty($roomType) && $roomType != 0)
                        $query->where('type', $roomType);
                    if (!empty($roomAdult) && $roomAdult != 0)
                        $query->where('bed_amount', $roomAdult);
                    if (!empty($roomChildren) && $roomChildren != -1)
                        $query->where('children_bed_amount', $roomChildren);
                    if (!empty($roomStatus) && $roomStatus != 0)
                        $query->where('status', $roomStatus);
                })
                    ->whereHas('bookings', function ($query) use ($startDate, $endDate) {
                        $query->where(function ($q) use ($startDate, $endDate) {
                            $q->where('check_in_date', '>=', $startDate)
                                ->where('check_in_date', '<=', $endDate);
                        })
                            ->orWhere(function ($q) use ($startDate, $endDate) {
                                $q->where('check_out_date', '>=', $startDate)
                                    ->where('check_out_date', '<=', $endDate);
                            });
                    })->get();
            }
            else if ($roomStatus != "free" || $roomStatus != "busy"){
                $rooms = Room::where(function ($query) use ($roomType, $roomAdult, $roomChildren, $roomStatus) {
                    if (!empty($roomType) && $roomType != 0)
                        $query->where('type', $roomType);
                    if (!empty($roomAdult) && $roomAdult != 0)
                        $query->where('bed_amount', $roomAdult);
                    if (!empty($roomChildren) && $roomChildren != -1)
                        $query->where('children_bed_amount', $roomChildren);
                    if (!empty($roomStatus) && $roomStatus != 0)
                        $query->where('status', $roomStatus);
                })->get();
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
}

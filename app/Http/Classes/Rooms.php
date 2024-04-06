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

    public function getById($id): ?object
    {
        try {
            $room = Room::with('room_properties')->where('id', $id)->first();
            if ($room->count() > 0) {
                return $room;
            } else {
                return null;
            }
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
            $roomType = $inputData['type'] ?? null;
            $roomStatus = $inputData['status'] ?? null;
            $roomAdult = $inputData['adultsBedsCount'] ?? null;
            $roomChildren = $inputData['childrenBedsCount'] ?? null;
            $properties = $inputData['additionalProperties'] ?? null;
            $firstName = null;
            $lastName = null;

            if ($roomNumber != null) {
                $rooms = Room::with('bookings')->with('room_properties')->where('room_number', $roomNumber)->get();
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
                $rooms = Room::with('bookings')->where('status', 'occupied')
                    ->where(function ($query) use ($roomType, $roomAdult, $roomChildren) {
                        if ($roomType != "0")
                            $query->where('type', $roomType);
                        if ($roomAdult != "0")
                            $query->where('adults_beds_count', '>=', $roomAdult);
                        if ($roomChildren != "-1")
                        {
                            if ($roomChildren == "0")
                                $query->where('children_beds_count', $roomChildren);
                            else
                                $query->where('children_beds_count', '>=', $roomChildren);
                        }
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
                    $freeRooms = Room::where('status', 'available')
                    ->where(function ($query) use ($roomType, $roomAdult, $roomChildren) {
                        if ($roomType != "0")
                            $query->where('type', $roomType);
                        if ($roomAdult != "0")
                            $query->where('adults_beds_count', '>=', $roomAdult);
                        if ($roomChildren != "-1")
                        {
                            if ($roomChildren == "0")
                                $query->where('children_beds_count', $roomChildren);
                            else
                                $query->where('children_beds_count', '>=', $roomChildren);
                        }
                    })
                    ->where(function ($subQuery) use ($properties) {
                        if (!empty($properties)) {
                            $subQuery->whereHas('room_properties', function ($doubleSubQuery) use ($properties) {
                                $doubleSubQuery->whereIn('id', $properties);
                            });
                        }
                    });
                $rooms = $rooms->union($freeRooms)->get();
            } elseif ($roomStatus == "occupied") {
                $startDate = $startDate . " 00:00:00";
                $endDate = $endDate . " 23:59:59";
                $rooms = Room::with('bookings')->where(function ($query) use ($roomType, $roomAdult, $roomChildren, $roomStatus) {
                    if ($roomType != "0")
                        $query->where('type', $roomType);
                    if ($roomAdult != "0")
                        $query->where('adults_beds_count', '>=', $roomAdult);
                    if ($roomChildren != "-1")
                    {
                        if ($roomChildren == "0")
                            $query->where('children_beds_count', $roomChildren);
                        else
                            $query->where('children_beds_count', '>=', $roomChildren);
                    }
                    if ($roomStatus != "0")
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
            else if ($roomStatus != "available" || $roomStatus != "occupied"){
                $rooms = Room::where(function ($query) use ($roomType, $roomAdult, $roomChildren, $roomStatus) {
                    if ($roomType != "0")
                        $query->where('type', $roomType);
                    if ($roomAdult != "0")
                        $query->where('adults_beds_count', '>=', $roomAdult);
                    if ($roomChildren != "-1")
                    {
                        if ($roomChildren == "0")
                            $query->where('children_beds_count', $roomChildren);
                        else
                            $query->where('children_beds_count', '>=', $roomChildren);
                    }
                    if ($roomStatus != "0")
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

    public function update($inputData, $id): ?bool
    {
        try{
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
            if (isset($inputData['additionalProperties'])){
                $room->room_properties()->detach();
                $room->room_properties()->attach($inputData['additionalProperties']);
            }
            return $result;
        }
        catch(Exception $e){
            return false;
        }
    }
}

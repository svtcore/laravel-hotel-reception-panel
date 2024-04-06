<?php

namespace App\Http\Classes;


use Exception;
use Illuminate\Support\Carbon;
use App\Models\Booking;
use App\Http\Classes\Rooms;
use App\Http\Classes\AdditionalServices;
use DateTime;
use phpDocumentor\Reflection\Types\Boolean;

class Bookings
{

    public function getLastCheckInOrders(): ?iterable
    {
        try {
            $today = Carbon::now()->format('Y-m-d');

            $checkInBookings = Booking::with([
                'guests',
                'rooms',
                'additional_services',
            ])->whereDate('check_in_date', '=', $today)
                ->where('status', 'reserved')
                ->orderBy('check_in_date', 'DESC')
                ->get();

            if ($checkInBookings->count() > 0) {
                return $checkInBookings;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getLastCheckOutOrders(): ?iterable
    {
        try {
            $today = Carbon::now()->format('Y-m-d');

            $checkOutBookings = Booking::with([
                'guests',
                'rooms',
                'additional_services',
            ])->whereDate('check_out_date', '=', $today)
                ->where('status', 'active')
                ->orderBy('check_out_date', 'DESC')
                ->get();

            if ($checkOutBookings->count() > 0) {
                return $checkOutBookings;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function searchByParams(array $inputData): ?iterable
    {
        try {
            $startDate = $inputData['startDate'] ?? null;
            $endDate = $inputData['endDate'] ?? null;
            $phoneNumber = $inputData['phoneNumber'] ?? null;
            $first_name = null;
            $last_name = null;

            if (isset($inputData['guestName'])) {
                [$first_name, $last_name] = explode(' ', $inputData['guestName']);
            }

            $searchResult = Booking::with([
                'guests',
                'rooms',
            ])->where(function ($query) use ($startDate, $endDate, $first_name, $last_name, $phoneNumber) {
                // by date
                if ($startDate != null && $endDate != null) {
                    $startDate = $startDate . " 00:00:00";
                    $endDate = $endDate . " 23:59:59";
                    $query->whereBetween('check_in_date', [$startDate, $endDate]);
                    $query->orWhereBetween('check_out_date', [$startDate, $endDate]);
                }

                // by guests
                if ($first_name != null && $last_name != null) {
                    $query->whereHas('guests', function ($subQuery) use ($first_name, $last_name) {
                        $subQuery->where('first_name', '=', $first_name)->where('last_name', '=', $last_name);
                    });
                }

                // by phone
                if ($phoneNumber != null) {
                    $query->whereHas('guests', function ($subQuery) use ($phoneNumber) {
                        $subQuery->where('phone_number', '=', $phoneNumber);
                    });
                }
            })
                ->orderBy('id', 'DESC')
                ->get();

            if ($searchResult->count() > 0) {
                return $searchResult;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    public function getById($id): ?Booking
    {
        try {
            $booking = Booking::with([
                'rooms',
                'guests',
                'additional_services'
            ])->where('id', $id)->first();
            if ($booking && $booking->count() > 0) {
                return $booking;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    public function update($validatedData, $id):?bool
    {
        try{
            $adults = $validatedData['adultsCount'];
            $children = $validatedData['childrenCount'];
            $check_in_date = $validatedData['checkInDate'];
            $check_out_date = $validatedData['checkOutDate'];
            $payment_type = $validatedData['paymentType'];
            $note = $validatedData['note'];
            $status = $validatedData['status'];
            if (isset($validatedData['additionalServices'])) {
                $additional_services_ids = $validatedData['additionalServices'];
            } else $additional_services_ids = [];

            $booking = Booking::findOrFail($id);
            $days = $this->diffDate($check_in_date, $check_out_date);
            $total_price = $this->calculatePrice($booking->room_id, $additional_services_ids, $days);
            $result = $booking->update([
                'adults_count' => $adults,
                'children_count' => $children,
                'total_cost' => $total_price,
                'payment_type' => $payment_type,
                'check_in_date' => $check_in_date,
                'check_out_date' => $check_out_date,
                'status' => $status,
                'note' => $note,
            ]);
            $booking->additional_services()->detach();
            $booking->additional_services()->attach($additional_services_ids);
            return $result;
        }
        catch(Exception $e){
            return null;
        }
    }

    public function calculatePrice($room_id, $ids, $days):?float
    {
        try{
            $rooms_obj = new Rooms();
            $additional_services_obj = new AdditionalServices();
            $room_price = ($rooms_obj->getById($room_id))->price;
            $services_price = $additional_services_obj->calculateSelected($ids, $days);
            $total_price = ($room_price * $days) + $services_price;
            if ($total_price > 0) return $total_price;
            else return 0;
        }
        catch(Exception $e){
            return null;
        }
    }

    public function diffDate($check_in_date, $check_out_date):?int
    {
        try{
            $dateTime1 = new DateTime($check_in_date);
            $dateTime2 = new DateTime($check_out_date);

            $interval = $dateTime1->diff($dateTime2);
            $daysDiff = $interval->days;
            if ($daysDiff < 0) $daysDiff = 0;
            elseif ($daysDiff == 0) $daysDiff = 1;
            return $daysDiff;
        }
        catch(Exception $e){
            return 0;
        }
    }

    public function deleteById($id): bool
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->additional_services()->detach();
            $booking->guests()->detach();
            $result = $booking->delete();
            return $result ? true : false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function changeStatus($status, $id):bool
    {
        try{
            $booking = Booking::findOrFail($id);
            $booking->update([
                'status' => $status,
            ]);
            return true;
        }
        catch(Exception $e){
            return false;
        }
    }

    public function getByRoomId($room_id): ?iterable
    {
        try{
            $booking = Booking::with('guests')
            ->where('room_id', $room_id)
            ->whereHas('guests')
            ->get();
            if ($booking->count() > 0) {
                return $booking;
            } else {
                return null;
            }
        }
        catch(Exception){
            return null;
        }
    }
}

<?php

namespace App\Http\Classes;


use Exception;
use Illuminate\Support\Carbon;
use App\Models\Booking;

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
            if ($booking->count() > 0) {
                return $booking;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }
}

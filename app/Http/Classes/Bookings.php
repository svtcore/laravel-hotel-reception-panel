<?php

namespace App\Http\Classes;


use Exception;
use Illuminate\Support\Carbon;
use App\Models\Booking;
use App\Http\Classes\Rooms;
use App\Http\Classes\AdditionalServices;
use DateTime;
use App\Http\Classes\Guests;
use phpDocumentor\Reflection\Types\Boolean;
use App\Models\Room;

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

    public function searchByParams(array $inputData, $trashed): ?iterable
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
                'rooms' => function ($q) use ($trashed) {
                    if ($trashed) {
                        $q->withTrashed();
                    }
                },
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
                        $subQuery
                            ->where('first_name', 'LIKE', "%$first_name%")
                            ->where('last_name',  'LIKE', "%$last_name%");
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

    public function update($validatedData, $id): ?bool
    {
        try {
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
        } catch (Exception $e) {
            return null;
        }
    }

    public function calculatePrice($room_id, $ids, $days): ?float
    {
        try {
            $rooms_obj = new Rooms();
            $additional_services_obj = new AdditionalServices();
            $room_price = ($rooms_obj->getById($room_id, false))->price;
            $services_price = $additional_services_obj->calculateSelected($ids, $days);
            $total_price = ($room_price * $days) + $services_price;
            if ($total_price > 0) return $total_price;
            else return 0;
        } catch (Exception $e) {
            return null;
        }
    }

    public function diffDate($check_in_date, $check_out_date): ?int
    {
        try {
            $dateTime1 = new DateTime($check_in_date);
            $dateTime2 = new DateTime($check_out_date);

            $interval = $dateTime1->diff($dateTime2);
            $daysDiff = $interval->days;
            if ($daysDiff < 0) $daysDiff = 0;
            elseif ($daysDiff == 0) $daysDiff = 1;
            return $daysDiff;
        } catch (Exception $e) {
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

    public function changeStatus($status, $id): bool
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->update([
                'status' => $status,
            ]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getByRoomId($room_id): ?iterable
    {
        try {
            $booking = Booking::with('guests')
                ->where('room_id', $room_id)
                ->whereHas('guests')
                ->get();
            if ($booking->count() > 0) {
                return $booking;
            } else {
                return null;
            }
        } catch (Exception) {
            return null;
        }
    }

    public function getByGuestId($id): ?iterable
    {
        try {
            $booking = Booking::with('rooms', 'guests')->whereHas('guests', function ($query) use ($id) {
                $query->where('guest_id', $id);
            })->get();
            if ($booking && $booking->count() > 0) {
                return $booking;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    public function searchByRoomNumber($room_number): ?iterable
    {
        try {
            $bookings = Booking::whereHas('rooms', function ($query) use ($room_number) {
                $query->where('room_number', $room_number)
                    ->where('status', 'available');
            })
                ->where('status', 'reserved')
                ->with(['guests', 'rooms'])
                ->get();
            if ($bookings && $bookings->count() > 0) {
                $filteredBookings = $bookings->map(function ($booking) {
                    return [
                        'order_id' => $booking->id,
                        'first_name' => $booking->guests->first()->first_name,
                        'last_name' => $booking->guests->first()->last_name,
                        'check_in_date' => $booking->check_in_date,
                    ];
                });

                return $filteredBookings;
            } else return null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function getAvailableDate($room_id)
    {
        try {
            $room = new Rooms();
            $room_data = $room->getById($room_id, false);
            if (isset($room_data->id)) {
                $bookings = Booking::where('room_id', $room_id)
                    ->whereIn('status', ['reserved', 'active', 'expired', 'completed'])
                    ->select('check_in_date', 'check_out_date')
                    ->orderBy('check_in_date', 'asc')
                    ->get();

                $currentDate = Carbon::now();

                $bookings = Booking::where('room_id', $room_id)
                    ->whereIn('status', ['reserved', 'active', 'expired', 'completed'])
                    ->select('check_in_date', 'check_out_date')
                    ->orderBy('check_in_date', 'asc')
                    ->get();

                $freePeriods = [];

                if ($bookings->count() > 0) {
                    $previousCheckOutDate = null;
                    $latestCheckOutDate = null;

                    foreach ($bookings as $booking) {
                        if ($previousCheckOutDate !== null) {
                            // Calculate free period between previous check_out_date and current check_in_date
                            $freePeriodStart = Carbon::parse($previousCheckOutDate);
                            $freePeriodEnd = Carbon::parse($booking->check_in_date);

                            if ($freePeriodStart->gt($currentDate)) {
                                $freePeriods[] = [
                                    'start' => $freePeriodStart->gt($currentDate) ? $freePeriodStart : $currentDate,
                                    'end' => $freePeriodEnd,
                                ];
                            }
                        }

                        $previousCheckOutDate = $booking->check_out_date;

                        if ($latestCheckOutDate === null || Carbon::parse($booking->check_out_date)->gt($latestCheckOutDate)) {
                            $latestCheckOutDate = $booking->check_out_date;
                        }
                    }
                }
                $free_dates = [];
                $count = 0;
                foreach ($freePeriods as $freePeriod) {
                    $dateRange = $freePeriod['start']->format('d.m.Y') . "  —  " . $freePeriod['end']->format('d.m.Y');
                    $free_dates[$count++] = $dateRange;
                }
                $last_date = NULL;
                if ($latestCheckOutDate !== null) {
                    $last_date = ($latestCheckOutDate > $currentDate ? $latestCheckOutDate : $currentDate);
                }
                return [$free_dates, $last_date];
            }
        } catch (Exception $e) {
            return null;
        }
    }

    public function checkDatesInRange($inputData, $free_dates, $last_date)
    {
        try {
            $inputCheckInDate = DateTime::createFromFormat('Y-m-d', $inputData['checkInDate']);
            $inputCheckOutDate = DateTime::createFromFormat('Y-m-d', $inputData['checkOutDate']);

            $dates = [];
            foreach ($free_dates as $free) {
                $dates[] = [
                    'startDate' => DateTime::createFromFormat('d.m.Y', explode('  —  ', $free)[0]),
                    'endDate' => DateTime::createFromFormat('d.m.Y', explode('  —  ', $free)[1])
                ];
            }
            $lastFreeDate = DateTime::createFromFormat('Y-m-d H:i:s', $last_date);

            // Проверяем входит ли диапазон дат в массив или больше ли он последней свободной даты
            $inRange = false;
            foreach ($dates as $dateRange) {
                if ($inputCheckInDate >= $dateRange['startDate'] && $inputCheckOutDate <= $dateRange['endDate']) {
                    $inRange = true;
                    break;
                }
            }
            $greaterThanLastFree = $inputCheckOutDate > $lastFreeDate;
            if ($inRange || $greaterThanLastFree) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }


    public function store($inputData)
    {
        try {
            $guest_obj = new Guests();
            $room = Room::findOrFail($inputData['room_id']);
            [$free_dates, $last_date] = $this->getAvailableDate($inputData['room_id']);
            if ($free_dates != null || $last_date != null)
                $dateRanges = $this->checkDatesInRange($inputData, $free_dates, $last_date);
            else $dateRanges = true;
            if ($dateRanges){
                $guest = $guest_obj->getByPhoneNumber($inputData);
                $booking = $room->bookings()->create([
                    'adults_count' => $inputData['adultsCount'],
                    'children_count' => $inputData['childrenCount'],
                    'total_cost' => 0,
                    'payment_type' => $inputData['paymentType'],
                    'check_in_date' => $inputData['checkInDate'],
                    'check_out_date' => $inputData['checkOutDate'],
                    'note' => $inputData['note'],
                    'status' => $inputData['status'],
                ]);
                $guest->bookings()->attach($booking->id);
                if (isset($inputData['additionalServices']))
                    $booking->additional_services()->attach($inputData['additionalServices']);
                $days = $this->diffDate($inputData['checkInDate'], $inputData['checkOutDate']);
                $price = $this->calculatePrice($inputData['room_id'], $inputData['additionalServices'] ?? array(), $days);
                $result = $booking->update([
                    'total_cost' => $price
                ]);
                if ($result) return $booking;
                else return null;
            }
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function bookingsSumByDay()
    {
        $currentDate = now();
        $currentMonth = $currentDate->month;
        $currentYear = $currentDate->year;

        $daysInMonth = $currentDate->day;

        $bookingsSumByDay = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $bookingsSumByDay[$day] = 0;
        }

        $bookingsData = Booking::where(function ($query) use ($currentMonth, $currentYear, $currentDate) {
            $query->whereYear('check_in_date', $currentYear)
                ->whereMonth('check_in_date', $currentMonth)
                ->whereDay('check_in_date', '>=', 1)
                ->whereDay('check_in_date', '<=', $currentDate->day)
                ->whereIn('status', ['active', 'completed', 'expired']);
        })
            ->orWhere(function ($query) use ($currentMonth, $currentYear, $currentDate) {
                $query->whereYear('check_out_date', $currentYear)
                    ->whereMonth('check_out_date', $currentMonth)
                    ->whereDay('check_out_date', '>=', 1)
                    ->whereDay('check_out_date', '<=', $currentDate->day)
                    ->whereIn('status', ['active', 'completed', 'expired']);
            })
            ->selectRaw('SUM(total_cost) as total, DAY(check_in_date) as day')
            ->groupByRaw('DAY(check_in_date)')
            ->orderByRaw('DAY(check_in_date)')
            ->get();

        foreach ($bookingsData as $booking) {
            $bookingsSumByDay[$booking->day] = $booking->total;
        }

        return $bookingsSumByDay;
    }

    public function checkInsCountByDay()
    {
        $currentDate = now();
        $currentMonth = $currentDate->month;
        $currentYear = $currentDate->year;

        $daysInMonth = $currentDate->daysInMonth;

        $checkInsCountByDay = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $checkInsCountByDay[$day] = 0;
        }

        $checkInsData = Booking::where(function ($query) use ($currentMonth, $currentYear, $currentDate) {
            $query->whereYear('check_in_date', $currentYear)
                ->whereMonth('check_in_date', $currentMonth)
                ->whereDay('check_in_date', '>=', 1)
                ->whereDay('check_in_date', '<=', $currentDate->day)
                ->whereIn('status', ['active', 'completed', 'expired']);
        })
            ->orWhere(function ($query) use ($currentMonth, $currentYear, $currentDate) {
                $query->whereYear('check_out_date', $currentYear)
                    ->whereMonth('check_out_date', $currentMonth)
                    ->whereDay('check_out_date', '>=', 1)
                    ->whereDay('check_out_date', '<=', $currentDate->day)
                    ->whereIn('status', ['active', 'completed', 'expired']);
            })
            ->selectRaw('COUNT(*) as count, DAY(check_in_date) as day')
            ->groupByRaw('DAY(check_in_date)')
            ->orderByRaw('DAY(check_in_date)')
            ->get();

        foreach ($checkInsData as $checkIn) {
            $checkInsCountByDay[$checkIn->day] = $checkIn->count;
        }

        return $checkInsCountByDay;
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Classes\Bookings;
use App\Http\Classes\Dashboard;
use App\Http\Classes\Rooms;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $booking = NULL;
    private $rooms = NULL;

    public function __construct()
    {
        $this->booking = new Bookings();
        $this->rooms = new Rooms();
    }

    public function index(){
        return view('admin.dashboard')->with([
            'sum_by_day' => json_encode(array_values($this->booking->bookingsSumByDay())) ?? array(),
            'room_data' => json_encode(array_values($this->rooms->getRoomTypesDemand())) ?? array(),
            'rooms_availability_data' => json_encode(array_values($this->rooms->getRoomsAvailabilityCount())) ?? array(),
            'bookings_by_day' => json_encode(array_values($this->booking->checkInsCountByDay())) ?? array(),
        ]);
    }
}

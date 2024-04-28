<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Classes\Bookings;
use App\Http\Classes\AdditionalServices;
use App\Http\Classes\Rooms;
use App\Http\Requests\admin\booking\ChangeStatusRequest;
use App\Http\Requests\admin\booking\SearchRequest;
use App\Http\Requests\admin\booking\ShowRequest;
use App\Http\Requests\admin\booking\StoreRequest;
use App\Http\Requests\admin\booking\UpdateRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookingController extends Controller
{

    private $booking = NULL;
    private $additional_services = NULL;
    private $rooms = NULL;

    public function __construct()
    {
        $this->booking = new Bookings();
        $this->rooms = new Rooms();
        $this->additional_services = new AdditionalServices();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('booking.index')->with([
            'check_in_bookings' => $this->booking->getLastCheckInOrders() ?? array(),
            'check_out_bookings' => $this->booking->getLastCheckOutOrders() ?? array(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $room = $this->rooms->getById($id, false);
        [$free_dates, $last_date] = $this->booking->getAvailableDate($id);
        if ($room) {
            return view('booking.create')->with([
                'avaliable_services' => $this->additional_services->getAvaliable() ?? array(),
                'room' => $room,
                'free_dates' => $free_dates,
                'last_free_date' =>  $last_date
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();

        if ($validatedData === null) {
            return response()->json(['errors' => 'Validation failed.'], 422);
        }
        $booking = $this->booking->store($validatedData);
        if ($booking) {
            return redirect()->route('admin.booking.show', $booking->id)->with('success', 'Booking data successful added');
        } else return redirect()->back()->withErrors(['error' => 'There is error in controller store']);
    }

    /**
     * Display the specified resource.
     * ID validation through routes
     */
    public function show($id)
    {
        try {
            $booking_data = $this->booking->getById($id);
            if ($booking_data === null) {
                return abort(404);
            } else {
                return view('booking.show')->with([
                    'booking_data' => $booking_data
                ]);
            }
        } catch (NotFoundHttpException $e) {
            return abort(404);
        } catch (Exception $e) {
            return abort(500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        [$free_dates, $last_date] = $this->booking->getAvailableDate($id);
        return view('booking.edit')->with([
            'booking_data' => $this->booking->getById($id) ?? abort(404),
            'avaliable_services' => $this->additional_services->getAvaliable() ?? array(),
            'free_dates' => $free_dates,
            'last_free_date' =>  $last_date
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $validatedData = $request->validated();

        if ($validatedData === null) {
            return response()->json(['errors' => 'Validation failed.'], 422);
        }

        $update_result = $this->booking->update($validatedData, $id);
        if ($update_result) {
            return redirect()->route('admin.booking.show', $id)->with('success', 'Booking data successful updated');
        } else return redirect()->back()->withErrors(['error' => 'There is error in controller update']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ($this->booking->deleteById($id)) {
            return redirect()->route('admin.booking.index')->with('success', 'Record successful deleted');
        } else return redirect()->back()->withErrors(['error' => __('The requested resource could not be found.')]);
    }
    /**
     * Search Booking by input params
     */
    public function searchByParams(SearchRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($validatedData === null) {
                return response()->withErrors(['errors' => 'Validation failed']);
            }
            $searchResult = $this->booking->searchByParams($validatedData, true);
            if (is_countable($searchResult) > 0) {
                return view('booking.search')->with(['result' => $searchResult, 'inputData' => $validatedData]);
            } else return redirect()->back()->withErrors(['errors' => 'There is no records found']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function changeStatus(ChangeStatusRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();

            if ($validatedData === null) {
                return response()->json(['errors' => 'Validation failed.'], 422);
            }
            if ($this->booking->changeStatus($validatedData['status'], $id)) {
                return redirect()->back()->with('success', 'Booking status successful updated');
            } else return redirect()->back()->withErrors(['errors' => 'Failed to change status']);
        } catch (Exception $e) {
            return response()->json(['errors' => 'changeStatus controller exception' + "\n" + $e], 422);
        }
    }
}

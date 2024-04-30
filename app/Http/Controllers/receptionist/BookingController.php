<?php

namespace App\Http\Controllers\receptionist;

use App\Http\Controllers\Controller;
use App\Http\Classes\Bookings;
use App\Http\Classes\AdditionalServices;
use App\Http\Classes\Rooms;
use App\Http\Requests\receptionist\booking\ChangeStatusRequest;
use App\Http\Requests\receptionist\booking\SearchRequest;
use App\Http\Requests\receptionist\booking\StoreRequest;
use App\Http\Requests\receptionist\booking\UpdateRequest;
use Exception;
use Illuminate\Validation\ValidationException;
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
     *
     * @return \Illuminate\Contracts\View\View
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
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
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
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();

        if ($validatedData === null) {
            return response()->json(['errors' => 'Validation failed.'], 422);
        }
        $booking = $this->booking->store($validatedData);
        if ($booking) {
            return redirect()->route('receptionist.booking.show', $booking->id)->with('success', 'Booking data successful added');
        } else return redirect()->back()->withErrors(['error' => 'There is error in controller store']);
    }

    /**
     * Display the specified resource.
     * ID validation through routes
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
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
     *
     * @param  string  $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(string $id)
    {
        return view('booking.edit')->with([
            'booking_data' => $this->booking->getById($id) ?? abort(404),
            'avaliable_services' => $this->additional_services->getAvaliable() ?? array()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, string $id)
    {
        $validatedData = $request->validated();

        if ($validatedData === null) {
            return response()->json(['errors' => 'Validation failed.'], 422);
        }

        $update_result = $this->booking->update($validatedData, $id);
        if ($update_result) {
            return redirect()->route('receptionist.booking.show', $id)->with('success', 'Booking data successful updated');
        } else return redirect()->back()->withErrors(['error' => 'There is error in controller update']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        if ($this->booking->deleteById($id)) {
            return redirect()->route('receptionist.booking.index')->with('success', 'Record successful deleted');
        } else return redirect()->back()->withErrors(['error' => __('The requested resource could not be found.')]);
    }

    /**
     * Search Booking by input params.
     *
     * @param  SearchRequest  $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
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

    /**
     * Change the status of the specified booking.
     *
     * @param  ChangeStatusRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
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

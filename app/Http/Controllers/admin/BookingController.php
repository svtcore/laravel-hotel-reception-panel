<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Classes\Bookings;
use App\Http\Classes\AdditionalServices;
use App\Http\Requests\booking\SearchRequest;
use App\Http\Requests\booking\ShowRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookingController extends Controller
{

    private $booking = NULL;
    private $additional_services = NULL;

    public function __construct()
    {
        $this->booking = new Bookings();
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        return view('booking.edit')->with([
            'booking_data' => $this->booking->getById($id) ?? array(),
            'avaliable_services' => $this->additional_services->getAvaliable() ?? array()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    /**
     * Search Booking by input params
     */
    public function searchByParams(SearchRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($validatedData === null) {
                return response()->json(['errors' => 'Validation failed.'], 422);
            }

            $searchResult = $this->booking->searchByParams($validatedData);
            if (is_countable($searchResult) > 0) {
                return view('booking.search')->with(['result' => $searchResult]);
            } else return abort(404);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}

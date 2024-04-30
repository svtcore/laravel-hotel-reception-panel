<?php

namespace App\Http\Controllers\receptionist;

use App\Http\Classes\RoomProperties;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Classes\Rooms;
use App\Http\Classes\Bookings;
use App\Http\Requests\receptionist\rooms\SearchRequest;
use App\Http\Requests\receptionist\rooms\StoreRequest;
use App\Http\Requests\receptionist\rooms\UpdateRequest;
use App\Models\Booking;
use Exception;
use Illuminate\Validation\ValidationException;

class RoomController extends Controller
{
    private $booking = NULL;
    private $rooms = NULL;
    private $room_properties = NULL;

    public function __construct()
    {
        $this->booking = new Bookings();
        $this->rooms = new Rooms();
        $this->room_properties = new RoomProperties();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('rooms.index')->with(['rooms' => $this->rooms->getFree() ?? array(), 'room_properties' => $this->room_properties->getAll() ?? array()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show(string $id)
    {

        return view('rooms.show')->with([
            'room' => $this->rooms->getById($id, true) ?? abort(404),
            'booking' => $this->booking->getByRoomId($id) ?? array(),
        ]);
    }

    /**
     * Search rooms by input parameters.
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
            $searchResult = $this->rooms->searchByParams($validatedData, true);
            if ($searchResult != null) {
                return view('rooms.search')->with(['result' => $searchResult ?? array(), 'room_properties' => $this->room_properties->getAll() ?? array(), 'inputData' => $validatedData]);
            } else return redirect()->route('receptionist.rooms.index')->withErrors(['errors' => 'There is no records found']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}

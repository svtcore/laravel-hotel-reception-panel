<?php

namespace App\Http\Controllers\admin;

use App\Http\Classes\RoomProperties;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Classes\Rooms;
use App\Http\Classes\Bookings;
use App\Http\Classes\CleaningLogs;
use App\Http\Requests\admin\rooms\SearchRequest;
use App\Http\Requests\admin\rooms\StoreRequest;
use App\Http\Requests\admin\rooms\UpdateRequest;
use App\Models\Booking;
use Exception;
use Illuminate\Validation\ValidationException;

class RoomController extends Controller
{
    private $booking = NULL;
    private $rooms = NULL;
    private $room_properties = NULL;
    private $cleaning = NULL;

    public function __construct()
    {
        $this->booking = new Bookings();
        $this->rooms = new Rooms();
        $this->room_properties = new RoomProperties();
        $this->cleaning = new CleaningLogs();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.rooms.index')->with(['rooms' => $this->rooms->getFree() ?? array(), 'room_properties' => $this->room_properties->getAll() ?? array()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rooms.create')->with([
            'room_properties' => $this->room_properties->getAll() ?? array()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($validatedData === null) {
                return response()->withErrors(['errors' => 'Validation failed']);
            }
            $result = $this->rooms->store($validatedData);
            if ($result != false && $result > 0) {
                return redirect()->route('admin.rooms.show', $result)->with('success', 'Room data successful added');
            } else return redirect()->back()->withErrors(['error' => 'There is error in while adding record']);
        } catch (Exception $e) {
            return response()->withErrors(['errors' => 'Error in adding room controller']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        return view('admin.rooms.show')->with([
            'room' => $this->rooms->getById($id, true) ?? abort(404),
            'booking' => $this->booking->getByRoomId($id) ?? array(),
            'cleaning' => $this->cleaning->getByRoomId($id) ?? array()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.rooms.edit')->with([
            'room_data' => $this->rooms->getById($id, false) ?? abort(404),
            'room_properties' => $this->room_properties->getAll() ?? array()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        try {
            $validatedData = $request->validated();

            if ($validatedData === null) {
                return response()->withErrors(['errors' => 'Validation failed']);
            }
            if ($this->rooms->update($validatedData, $id)) {
                return redirect()->route('admin.rooms.show', $id)->with('success', 'Room data successful updated');
            } else return redirect()->back()->withErrors(['error' => 'There is error in while updating record']);
        } catch (Exception $e) {
            return response()->withErrors(['errors' => 'Error in update room controller']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ($this->rooms->deleteById($id)) {
            return redirect()->route('admin.rooms.index')->with('success', 'Record successful deleted');
        } else return redirect()->back()->withErrors(['error' => __('The requested resource could not be found.')]);
    }

    //

    public function searchByParams(SearchRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($validatedData === null) {
                return response()->withErrors(['errors' => 'Validation failed']);
            }
            $searchResult = $this->rooms->searchByParams($validatedData, true);
            if ($searchResult != null) {
                return view('admin.rooms.search')->with(['result' => $searchResult ?? array(), 'room_properties' => $this->room_properties->getAll() ?? array(), 'inputData' => $validatedData]);
            } else return redirect()->route('admin.rooms.index')->withErrors(['errors' => 'There is no records found']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}

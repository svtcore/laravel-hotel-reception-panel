<?php

namespace App\Http\Controllers\admin;

use App\Http\Classes\RoomProperties;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Classes\Rooms;
use App\Http\Classes\Bookings;
use App\Http\Classes\CleaningLogs;
use App\Http\Requests\admin\rooms\SearchRequest;
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
     */
    public function show(string $id)
    {
        
        return view('admin.rooms.show')->with([
            'room' => $this->rooms->getById($id),
            'booking' => $this->booking->getByRoomId($id) ?? array(),
            'cleaning' => $this->cleaning->getByRoomId($id) ?? array()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.rooms.edit')->with([
            'room_data' => $this->rooms->getById($id) ?? array(),
            'room_properties' => $this->room_properties->getAll() ?? array()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        try{
            $validatedData = $request->validated();

            if ($validatedData === null) {
                return response()->withErrors(['errors' => 'Validation failed']);
            }
            if ($this->rooms->update($validatedData, $id)){
                return redirect()->route('admin.rooms.show', $id)->with('success', 'Room data successful updated');
            }else return redirect()->back()->withErrors(['error' => 'There is error in while updating record']);
        }
        catch(Exception $e){
            return response()->withErrors(['errors' => 'Error in update room controller']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    //

    public function searchByParams(SearchRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($validatedData === null) {
                return response()->withErrors(['errors' => 'Validation failed']);
            }
            $searchResult = $this->rooms->searchByParams($validatedData);
            if ($searchResult != null) {
                return view('admin.rooms.search')->with(['result' => $searchResult ?? array(), 'room_properties' => $this->room_properties->getAll() ?? array(), 'inputData' => $validatedData]);
            } else return redirect()->route('admin.rooms.index')->withErrors(['errors' => 'There is no records found']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

    }
}

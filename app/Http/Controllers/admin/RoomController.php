<?php

namespace App\Http\Controllers\admin;

use App\Http\Classes\RoomProperties;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Classes\Rooms;
use App\Http\Classes\Bookings;
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

    public function __construct()
    {
        $this->booking = new Bookings();
        $this->rooms = new Rooms();
        $this->room_properties = new RoomProperties();
    }

    /**
     * Display a listing of rooms.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory Returns the view for displaying a listing of rooms.
     */
    public function index()
    {
        return view('rooms.index')->with(['rooms' => $this->rooms->getFree() ?? array(), 'room_properties' => $this->room_properties->getAll() ?? array()]);
    }

    /**
     * Show the form for creating a new room.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory Returns the view for creating a new room.
     */
    public function create()
    {
        return view('rooms.create')->with([
            'room_properties' => $this->room_properties->getAll() ?? array()
        ]);
    }

    /**
     * Store a newly created room in storage.
     *
     * @param StoreRequest $request The request containing validated data for creating a room.
     * @return \Illuminate\Http\RedirectResponse Returns a redirect response to the room details page with success message upon successful addition, otherwise redirects back with error message.
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
            return redirect()->back()->withErrors(['error' => 'Error while adding room record']);
        }
    }

    /**
     * Display the specified room.
     *
     * @param string $id The ID of the room to be displayed.
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory Returns the view for displaying the room details.
     */
    public function show(string $id)
    {

        return view('rooms.show')->with([
            'room' => $this->rooms->getById($id, true) ?? abort(404),
            'booking' => $this->booking->getByRoomId($id) ?? array(),
        ]);
    }

    /**
     * Show the form for editing the specified room.
     *
     * @param string $id The ID of the room to be edited.
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory Returns the view for editing the room details.
     */
    public function edit(string $id)
    {
        return view('rooms.edit')->with([
            'room_data' => $this->rooms->getById($id, false) ?? abort(404),
            'room_properties' => $this->room_properties->getAll() ?? array()
        ]);
    }

    /**
     * Update the specified room in storage.
     *
     * @param UpdateRequest $request The request containing validated data for updating a room.
     * @param string $id The ID of the room to be updated.
     * @return \Illuminate\Http\RedirectResponse Returns a redirect response to the room details page with success message upon successful update, otherwise redirects back with error message.
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
            return redirect()->back()->withErrors(['error' => 'There is error in while updating record']);
        }
    }

    /**
     * Remove the specified room from storage.
     *
     * @param string $id The ID of the room to be deleted.
     * @return \Illuminate\Http\RedirectResponse Returns a redirect response to the room index page with success message upon successful deletion, otherwise redirects back with error message.
     */
    public function destroy(string $id)
    {
        if ($this->rooms->deleteById($id)) {
            return redirect()->route('admin.rooms.index')->with('success', 'Record successful deleted');
        } else return redirect()->back()->withErrors(['error' => __('The requested resource could not be found.')]);
    }

    /**
     * Search for rooms by input parameters.
     *
     * @param SearchRequest $request The request containing validated search parameters.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory Returns a view displaying search results with input parameters if records are found, otherwise redirects back with error message.
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
            } else return redirect()->route('admin.rooms.index')->withErrors(['errors' => 'There is no records found']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}

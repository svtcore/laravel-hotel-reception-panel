<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Classes\Guests;
use App\Http\Classes\Bookings;
use App\Http\Requests\admin\guests\UpdateRequest;
use Exception;

class GuestController extends Controller
{
    private $guests;
    private $bookings;

    public function __construct()
    {
        $this->guests = new Guests();
        $this->bookings = new Bookings();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.guests.index')->with([
            'guests' => $this->guests->getLast(50) ?? array()
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
     */
    public function show(string $id)
    {
        return view('admin.guests.show')->with([
            'guest' => $this->guests->getById($id) ?? abort(404),
            'bookings' => $this->bookings->getByGuestId($id) ?? array(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.guests.edit')->with([
            'guest' => $this->guests->getById($id) ?? abort(404),
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
            if ($this->guests->update($validatedData, $id)) {
                return redirect()->route('admin.guests.show', $id)->with('success', 'Guest data successful updated');
            } else return redirect()->back()->withErrors(['error' => 'There is error in while updating record']);
        } catch (Exception $e) {
            return response()->withErrors(['errors' => 'Error in update guest controller']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ($this->guests->deleteById($id)) {
            return redirect()->route('admin.guests.index')->with('success', 'Record successful deleted');
        } else return redirect()->back()->withErrors(['error' => __('The requested resource could not be found.')]);
    }
}

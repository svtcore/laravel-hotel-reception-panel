<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Classes\Guests;
use App\Http\Classes\Bookings;
use App\Http\Requests\admin\booking\DeleteRelationRequest;
use App\Http\Requests\admin\guests\SearchRelationGuest;
use App\Http\Requests\admin\guests\SearchRelationRequest;
use App\Http\Requests\admin\guests\SearchRequest;
use App\Http\Requests\admin\guests\StoreRequest;
use App\Http\Requests\admin\guests\SubmitRelationRequest;
use App\Http\Requests\admin\guests\UpdateRequest;
use Exception;
use Illuminate\Validation\ValidationException;

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
        return view('guests.index')->with([
            'guests' => $this->guests->getLast(50) ?? array()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('guests.create');
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
            $result = $this->guests->store($validatedData);
            if ($result) {
                return redirect()->route('admin.guests.show', $result)->with('success', 'Guest data successful added');
            } else return redirect()->back()->withErrors(['error' => 'There is error in while added record']);
        } catch (Exception $e) {
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('guests.show')->with([
            'guest' => $this->guests->getById($id) ?? abort(404),
            'bookings' => $this->bookings->getByGuestId($id) ?? array(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('guests.edit')->with([
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

    public function relation(SearchRelationRequest $request)
    {
        $validatedData = $request->validated();

        if ($validatedData === null) {
            return response()->json(['error' => 'true', 'message' => 'validation_failed']);
        }
        $result = $this->bookings->searchByRoomNumber($validatedData['roomNumber']);
        if ($result != null) return $result;
        else return response()->json(['error' => 'true', 'message' => 'returned_null']);
        return $result;
    }

    /**
     * Search Guests by input params
     */
    public function searchByParams(SearchRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($validatedData === null) {
                return response()->withErrors(['errors' => 'Validation failed']);
            }
            $searchResult = $this->guests->searchByParams($validatedData, true);
            if (is_countable($searchResult) > 0) {
                return view('guests.search')->with(['guests' => $searchResult, 'inputData' => $validatedData]);
            } else return redirect()->back()->withErrors(['errors' => 'There is no records found']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function deleteRelation(DeleteRelationRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($validatedData === null) {
                return response()->json(['error' => 'true', 'message' => 'validation_failed']);
            }
            if ($this->bookings->deleteRelation($validatedData)) {
                return redirect()->back()->with(['success' => 'Relation successful deleted']);
            } else return redirect()->back()->withErrors(['errors' => 'There is no error while deleting relation']);
        } catch (Exception $e) {
            return null;
        }
    }

    public function searchRelation(SearchRelationGuest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($validatedData === null) {
                return response()->json(['error' => 'true', 'message' => 'validation_failed']);
            }
            $guest = $this->guests->searchRelationGuest($validatedData);
            if ($guest != null) {
                return $guest;
            } else return null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function submitRelation(SubmitRelationRequest $request)
    {
        try {
            $validatedData = $request->validated();
            if ($validatedData === null) {
                return redirect()->back()->withErrors(['errors' => 'There is no error while deleting relation']);
            }
            $guest = $this->guests->submitRelation($validatedData);
            if ($guest != null) {
                return redirect()->back()->with(['success', 'Relation successful added']);
            } else return redirect()->back()->withErrors(['errors' => 'There is no error while deleting relation']);
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->withErrors(['errors' => 'There is no error while deleting relation']);
        }
    }
}

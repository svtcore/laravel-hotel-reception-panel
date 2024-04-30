<?php

namespace App\Http\Controllers\receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Classes\Guests;
use App\Http\Classes\Bookings;
use App\Http\Requests\receptionist\booking\DeleteRelationRequest;
use App\Http\Requests\receptionist\guests\SearchRelationGuest;
use App\Http\Requests\receptionist\guests\SearchRelationRequest;
use App\Http\Requests\receptionist\guests\SearchRequest;
use App\Http\Requests\receptionist\guests\StoreRequest;
use App\Http\Requests\receptionist\guests\SubmitRelationRequest;
use App\Http\Requests\receptionist\guests\UpdateRequest;
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
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('guests.index')->with([
            'guests' => $this->guests->getLast(50) ?? array()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('guests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\RedirectResponse
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
                return redirect()->route('receptionist.guests.show', $result)->with('success', 'Guest data successful added');
            } else return redirect()->back()->withErrors(['error' => 'There is error in while added record']);
        } catch (Exception $e) {
            dd($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
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
     *
     * @param  string  $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(string $id)
    {
        return view('guests.edit')->with([
            'guest' => $this->guests->getById($id) ?? abort(404),
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
        try {
            $validatedData = $request->validated();

            if ($validatedData === null) {
                return response()->withErrors(['errors' => 'Validation failed']);
            }
            if ($this->guests->update($validatedData, $id)) {
                return redirect()->route('receptionist.guests.show', $id)->with('success', 'Guest data successful updated');
            } else return redirect()->back()->withErrors(['error' => 'There is error in while updating record']);
        } catch (Exception $e) {
            return response()->withErrors(['errors' => 'Error in update guest controller']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        if ($this->guests->deleteById($id)) {
            return redirect()->route('receptionist.guests.index')->with('success', 'Record successful deleted');
        } else return redirect()->back()->withErrors(['error' => __('The requested resource could not be found.')]);
    }

    /**
     * Search for related bookings by room number.
     *
     * @param  SearchRelationRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
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
     * Search guests by input parameters.
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
            $searchResult = $this->guests->searchByParams($validatedData, false);
            if (is_countable($searchResult) > 0) {
                return view('guests.search')->with(['guests' => $searchResult, 'inputData' => $validatedData]);
            } else return redirect()->back()->withErrors(['errors' => 'There is no records found']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Delete a relation between bookings and guests.
     *
     * @param  DeleteRelationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Search for guest relation.
     *
     * @param  SearchRelationGuest  $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Submit guest relation.
     *
     * @param  SubmitRelationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitRelation(SubmitRelationRequest $request)
    {
        try {
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
                return redirect()->back()->withErrors(['errors' => 'There is no error while deleting relation']);
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'There is no error while deleting relation']);
        }
    }
}

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
     * Display a listing of guests.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory Returns the view for displaying a listing of guests.
     */
    public function index()
    {
        return view('guests.index')->with([
            'guests' => $this->guests->getLast(50) ?? array()
        ]);
    }

    /**
     * Show the form for creating a new guest.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory Returns the view for creating a new guest.
     */
    public function create()
    {
        return view('guests.create');
    }

    /**
     * Store a newly created guest in storage.
     *
     * @param StoreRequest $request The request containing validated data for creating a guest.
     * @return \Illuminate\Http\RedirectResponse Returns a redirect response to the guest details page with success message upon successful addition, otherwise redirects back with error message.
     */
    public function store(StoreRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $result = $this->guests->store($validatedData);
            if ($result) {
                return redirect()->route('admin.guests.show', $result)->with('success', 'Guest data successfully added');
            } else return redirect()->back()->withErrors(['error' => 'There was an error while adding the record']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error occurred while processing your request']);
        }
    }

    /**
     * Display the specified guest data.
     *
     * @param string $id The ID of the guest to be displayed.
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory Returns the view for displaying the guest details.
     */

    public function show(string $id)
    {
        return view('guests.show')->with([
            'guest' => $this->guests->getById($id) ?? abort(404),
            'bookings' => $this->bookings->getByGuestId($id) ?? array(),
        ]);
    }

    /**
     * Show the form for editing the specified guest.
     *
     * @param string $id The ID of the guest to be edited.
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory Returns the view for editing the guest details.
     */
    public function edit(string $id)
    {
        return view('guests.edit')->with([
            'guest' => $this->guests->getById($id) ?? abort(404),
        ]);
    }

    /**
     * Update the specified guest in storage.
     *
     * @param UpdateRequest $request The request containing validated data for updating a guest.
     * @param string $id The ID of the guest to be updated.
     * @return \Illuminate\Http\RedirectResponse Returns a redirect response to the guest details page with success message upon successful update, otherwise redirects back with error message.
     */

    public function update(UpdateRequest $request, string $id)
    {
        try {
            $validatedData = $request->validated();

            if ($this->guests->update($validatedData, $id)) {
                return redirect()->route('admin.guests.show', $id)->with('success', 'Guest data successfully updated');
            } else return redirect()->back()->withErrors(['error' => 'There was an error while updating the record']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error occurred while processing your request']);
        }
    }

    /**
     * Remove the specified guest from storage.
     *
     * @param string $id The ID of the guest to be deleted.
     * @return \Illuminate\Http\RedirectResponse Returns a redirect response to the guest index page with success message upon successful deletion, otherwise redirects back with error message.
     */
    public function destroy(string $id)
    {
        if ($this->guests->deleteById($id)) {
            return redirect()->route('admin.guests.index')->with('success', 'Guest record successfully deleted');
        } else return redirect()->back()->withErrors(['error' => 'Error occurred while processing your request']);
    }

    /**
     * Search bookings by room number relation.
     *
     * @param SearchRelationRequest $request The request containing validated data for searching bookings by room number.
     * @return \Illuminate\Http\JsonResponse Returns JSON response with search result if found, otherwise returns error message.
     */
    public function relation(SearchRelationRequest $request)
    {
        $validatedData = $request->validated();

        $result = $this->bookings->searchByRoomNumber($validatedData['roomNumber']);
        if ($result != null) return $result;
        else return response()->json(['error' => 'true', 'message' => 'returned_null']);
        return $result;
    }

    /**
     * Search for guests by input parameters.
     *
     * @param SearchRequest $request The request containing validated search parameters.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory Returns a view displaying search results with input parameters if records are found, otherwise redirects back with error message.
     */
    public function searchByParams(SearchRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $searchResult = $this->guests->searchByParams($validatedData, true);
            if (is_countable($searchResult) > 0) {
                return view('guests.search')->with(['guests' => $searchResult, 'inputData' => $validatedData]);
            } else return redirect()->back()->withErrors(['error' => 'No records found']);
        } catch (ValidationException $e) {
            return response()->back()->withErrors(['error' => 'Error occurred while processing your request']);
        }
    }

    /**
     * Delete relation between bookings and guests.
     *
     * @param DeleteRelationRequest $request The request containing validated data for deleting relation between bookings and guests.
     * @return \Illuminate\Http\RedirectResponse Returns a redirect response back to the previous page with success message upon successful deletion, otherwise redirects back with error message.
     */
    public function deleteRelation(DeleteRelationRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($this->bookings->deleteRelation($validatedData)) {
                return redirect()->back()->with(['success' => 'Relation successfully deleted']);
            } else return redirect()->back()->withErrors(['error' => 'There were no errors while deleting the relation']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error occurred while processing your request']);
        }
    }

    /**
     * Search for guest relation by input parameters.
     *
     * @param SearchRelationGuest $request The request containing validated search parameters.
     * @return \Illuminate\Http\JsonResponse|null Returns JSON response with guest relation if found, otherwise returns null.
     */
    public function searchRelation(SearchRelationGuest $request)
    {
        try {
            $validatedData = $request->validated();

            $guest = $this->guests->searchRelationGuest($validatedData);
            if ($guest != null) {
                return $guest;
            } else return null;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Submit guest relation based on input parameters.
     *
     * @param SubmitRelationRequest $request The request containing validated data for submitting guest relation.
     * @return \Illuminate\Http\RedirectResponse Returns a redirect response back to the previous page with success message upon successful submission, otherwise redirects back with error message.
     */
    public function submitRelation(SubmitRelationRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $guest = $this->guests->submitRelation($validatedData);
            if ($guest != null) {
                return redirect()->back()->with(['success', 'The relation was successfully added']);
            } else return redirect()->back()->withErrors(['error' => 'There were no errors while deleting the relation']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error occurred while processing your request']);
        }
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Classes\RoomProperties;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\rooms\properties\StoreRequest;
use App\Http\Requests\admin\rooms\properties\UpdateRequest;
use Exception;
use Illuminate\Http\Request;

class RoomPropertyController extends Controller
{
    private $room_properties;

    public function __construct()
    {
        $this->room_properties = new RoomProperties();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('rooms.properties.index')->with([
            'properties' => $this->room_properties->getAll() ?? array(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rooms.properties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try{
            $validateData = $request->validated();
            if ($this->room_properties->store($validateData)){
                return redirect()->route('admin.rooms.properties.index')->with('success', 'Room property successfully added');
            }else return redirect()->back()->withErrors(['error' => 'There was an error while adding room property data']);
        }
        catch(Exception $e){
            return redirect()->back()->withErrors(['error' => 'Error occurred while processing your request']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('rooms.properties.edit')->with([
            'property' => $this->room_properties->getById($id) ?? array(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        try{
            $validateData = $request->validated();
            if ($this->room_properties->update($validateData, $id)){
                return redirect()->route('admin.rooms.properties.index')->with('success', 'Room property data successfully updated');
            }else return redirect()->back()->withErrors(['error' => 'There was an error while updating the room property']);
        }
        catch(Exception $e){
            return redirect()->back()->withErrors(['error' => 'Error occurred while processing your request']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            if ($this->room_properties->destory($id)){
                return redirect()->route('admin.rooms.properties.index')->with('success', 'Room property successfully deleted');
            }else return redirect()->back()->withErrors(['error' => 'There was an error while deleting the room property record']);
        }
        catch(Exception $e){
            return redirect()->back()->withErrors(['error' => 'Error occurred while processing your request']);
        }
    }
}

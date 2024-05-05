<?php

namespace App\Http\Controllers\admin;

use App\Http\Classes\AdditionalServices;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\services\StoreRequest;
use App\Http\Requests\admin\services\UpdateRequest;
use Exception;
use Illuminate\Http\Request;

class AdditionalServiceController extends Controller
{

    private $services;

    public function __construct()
    {
        $this->services = new AdditionalServices();
    }

    /**
     * Display the index page with additional services.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('additional_services.index')->with([
            'services' => $this->services->getAll() ?? array(),
        ]);
    }

    /**
     * Display the form for creating a new additional service.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('additional_services.create');
    }
    /**
     * Store a newly created additional service in storage.
     *
     * @param  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($this->services->store($validatedData)) {
                return redirect()->route('admin.services.index')->with(['success' => 'Additional service successfully added']);
            } else return redirect()->back()->withErrors(['error' => 'Failed to add additional service']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Error occurred while processing your request']);
        }
    }

    /**
     * Show the form for editing the specified additional service.
     *
     * @param  string  $id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(string $id)
    {
        try {
            return view('additional_services.edit')->with([
                'service' => $this->services->getById($id) ?? abort(404),
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' =>'Error occurred while processing your request']);
        }
    }

    /**
     * Update the specified additional service in storage.
     *
     * @param  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, int $id)
    {
        try {
            $validatedData = $request->validated();
            if ($this->services->update($validatedData, $id)) {
                return redirect()->route('admin.services.index')->with('success', 'Additional service successfully updated');
            } else return redirect()->back()->withErrors(['error' => 'Failed to add additional service']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error occurred while processing your request']);
        }
    }


    /**
     * Remove the specified additional service from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        try {
            if ($this->services->destroy($id)) {
                return redirect()->route('admin.services.index')->with('success', 'Additional service successfully deleted');
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error occurred while processing your request']);
        }
    }
}

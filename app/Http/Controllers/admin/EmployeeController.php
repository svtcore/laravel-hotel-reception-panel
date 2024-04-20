<?php

namespace App\Http\Controllers\admin;

use App\Http\Classes\Employees;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\employees\StoreRequest;
use App\Http\Requests\admin\employees\UpdateRequest;
use Illuminate\Http\Request;
use Exception;

class EmployeeController extends Controller
{
    private $employees = NULL;

    public function __construct()
    {
        $this->employees = new Employees();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.employees.index')->with([
            'employees' => $this->employees->getAll() ?? array()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.employees.create');
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
            if ($this->employees->store($validatedData)) {
                return redirect()->route('admin.employees.index')->with('success', 'Employee data successful added');
            } else return redirect()->back()->withErrors(['error' => 'There is error in while adding record']);
        } catch (Exception $e) {
            return response()->withErrors(['errors' => 'Error in adding employee controller']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.employees.edit')->with([
            'employee' => $this->employees->getById($id) ?? abort(404)
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
            if ($this->employees->update($validatedData, $id)) {
                return redirect()->route('admin.employees.index')->with('success', 'Employee data successful updated');
            } else return redirect()->back()->withErrors(['error' => 'There is error in while updating record']);
        } catch (Exception $e) {
            return response()->withErrors(['errors' => 'Error in update employee controller']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            if ($this->employees->delete($id))
                return redirect()->route('admin.employees.index')->with('success', 'Employee deleted successfully');
            else return redirect()->route('admin.employees.index')->with('error', 'Error while deleting record');
        } catch (Exception $e) {
            return redirect()->route('admin.employees.index')->with('error', 'Error while deleting record');
        }
    }
}

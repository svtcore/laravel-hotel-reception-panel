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
     * Display a listing of employees.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory Returns the view for displaying a listing of employees.
     */
    public function index()
    {
        return view('employees.index')->with([
            'employees' => $this->employees->getAll() ?? array()
        ]);
    }

    /**
     * Show the form for creating a new employee.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory Returns the view for creating a new employee.
     */

    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created employee in storage.
     *
     * @param StoreRequest $request The request containing validated data for creating an employee.
     * @return \Illuminate\Http\RedirectResponse Returns a redirect response to the employee index page with success message upon successful addition, otherwise redirects back with error message.
     */
    public function store(StoreRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($this->employees->store($validatedData)) {
                return redirect()->route('admin.employees.index')->with('success', 'Employee data successfully added');
            } else {
                return redirect()->back()->withErrors(['error' => 'There was an error while adding the record']);
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error occurred while processing your request']);
        }
    }


    /**
     * Show the form for editing the specified employee.
     *
     * @param string $id The ID of the employee to be edited.
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory Returns the view for editing the employee details.
     */
    public function edit(string $id)
    {
        return view('employees.edit')->with([
            'employee' => $this->employees->getById($id) ?? abort(404)
        ]);
    }

    /**
     * Update the specified employee in storage.
     *
     * @param UpdateRequest $request The request containing validated data for updating an employee.
     * @param string $id The ID of the employee to be updated.
     * @return \Illuminate\Http\RedirectResponse Returns a redirect response to the employee index page with success message upon successful update, otherwise redirects back with error message.
     */
    public function update(UpdateRequest $request, string $id)
    {
        try {
            $validatedData = $request->validated();

            if ($this->employees->update($validatedData, $id)) {
                return redirect()->route('admin.employees.index')->with('success', 'Employee data successfully updated');
            } else {
                return redirect()->back()->withErrors(['error' => 'There was an error while updating the record']);
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error occurred while processing your request']);
        }
    }


    /**
     * Remove the specified employee from storage.
     *
     * @param string $id The ID of the employee to be deleted.
     * @return \Illuminate\Http\RedirectResponse Returns a redirect response to the employee index page with success message upon successful deletion, otherwise redirects back with error message.
     */

    public function destroy($id)
    {
        try {
            if ($this->employees->delete($id))
                return redirect()->route('admin.employees.index')->with('success', 'Employee deleted successfully');
            else return redirect()->route('admin.employees.index')->withErrors(['error' => 'There was an error while deleting the record']);
        } catch (Exception $e) {
            return redirect()->route('admin.employees.index')->withErrors(['error' => 'Error occurred while processing your request']);
        }
    }
}

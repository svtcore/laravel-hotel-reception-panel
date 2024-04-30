<?php

namespace App\Http\Controllers\receptionist;

use App\Http\Classes\Employees;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    private $employees = NULL;

    public function __construct()
    {
        $this->employees = new Employees();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('employees.index')->with([
            'employees' => $this->employees->getAll() ?? array()
        ]);
    }
}

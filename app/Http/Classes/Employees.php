<?php

namespace App\Http\Classes;

use App\Models\Employee;
use Exception;

class Employees
{
    /**
     * Retrieves all employees.
     *
     * @return \Illuminate\Database\Eloquent\Collection|null A collection of all employees, or null if no employees are found.
     */
    public function getAll(): ?iterable
    {
        try {
            $employees = Employee::all();
            if ($employees && $employees->count() > 0) {
                return $employees;
            } else return null;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Retrieves an employee by their ID.
     *
     * @param int $id The ID of the employee to retrieve.
     * @return \App\Models\Employee|null The employee object if found, or null if no employee with the specified ID is found.
     */
    public function getById($id): ?object
    {
        try {
            $employee = Employee::where('id', $id)->first();
            if ($employee) {
                return $employee;
            } else return null;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Updates an employee's information.
     *
     * @param array $inputData An array containing the updated information for the employee.
     * @param int $id The ID of the employee to update.
     * @return bool True if the employee's information was successfully updated, false otherwise.
     */
    public function update($inputData, $id): bool
    {
        try {
            $employee = Employee::findOrFail($id);
            $result = $employee->update([
                'first_name' => $inputData['firstName'],
                'last_name' => $inputData['lastName'],
                'dob' => $inputData['dob'],
                'phone_number' => $inputData['phoneNumber'],
                'position' => $inputData['position'],
                'status' => $inputData['status']
            ]);
            if ($result) return true;
            else return false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Stores a new employee.
     *
     * @param array $inputData An array containing the information of the new employee to store.
     * @return bool True if the employee was successfully stored, false otherwise.
     */
    public function store($inputData): bool
    {
        try {
            $result = Employee::create([
                'first_name' => $inputData['firstName'],
                'last_name' => $inputData['lastName'],
                'dob' => $inputData['dob'],
                'phone_number' => $inputData['phoneNumber'],
                'position' => $inputData['position'],
                'status' => $inputData['status']
            ]);
            if ($result) return true;
            else return false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Deletes an employee by their ID.
     *
     * @param int $id The ID of the employee to delete.
     * @return bool True if the employee was successfully deleted, false otherwise.
     */
    public function delete($id): bool
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

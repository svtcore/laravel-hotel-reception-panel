<?php

namespace App\Http\Classes;

use App\Models\Employee;
use Exception;

class Employees
{
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

<?php

namespace App\Http\Classes;


use Exception;
use Illuminate\Support\Carbon;
use App\Models\AdditionalService;

class AdditionalServices
{

    /**
     * Retrieve all additional services.
     *
     * @return iterable|null Returns an iterable collection of additional services if available, otherwise returns null.
     */
    public function getAll(): ?iterable
    {
        try {
            $services = AdditionalService::orderBy('name')->get();
            if ($services && $services->count() > 0) {
                return $services;
            } else return null;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Retrieves available additional services.
     *
     * @return \Illuminate\Support\Collection|null A collection of available additional services or null if none are found.
     */
    public function getAvailable(): ?iterable
    {
        try {
            $services = AdditionalService::where('available', 1)->orderBy('name')->get();
            if ($services && $services->count() > 0) {
                return $services;
            } else return null;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Calculates the total cost of selected additional services.
     *
     * @param array $ids An array of additional service IDs.
     * @return float The total cost of selected additional services.
     */
    public function calculateSelected($ids): float
    {
        try {
            $services = AdditionalService::whereIn('id', $ids)->get();
            if ($services && $services->count() > 0) {
                $cost = 0;
                foreach ($services as $service) {
                    $cost = $cost + $service->price;
                }
                return $cost;
            } else {
                return 0;
            }
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Store a new additional service in the database.
     *
     * @param array $inputData The data for creating the additional service, including name, price, and availability status.
     * @return bool Returns true if the service is successfully stored, otherwise false.
     */
    public function store($inputData): bool
    {
        try {
            $result = AdditionalService::create([
                'name' => $inputData['name'],
                'price' => $inputData['price'],
                'available' => $inputData['status'],
            ]);
            return $result ? true : false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retrieve an additional service by its ID.
     *
     * @param int $id The ID of the additional service to retrieve.
     * @return object|null Returns the additional service object if found, otherwise null.
     */
    public function getById(int $id): ?object
    {
        try {
            $service = AdditionalService::where('id', $id)->first();
            return $service ? $service : null;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Update an existing additional service.
     *
     * @param array $inputData The updated data for the additional service, including name, price, and availability status.
     * @param int $id The ID of the additional service to update.
     * @return bool Returns true if the update is successful, otherwise false.
     */
    public function update($inputData, int $id): bool
    {
        try {
            $service = AdditionalService::findOrFail($id);
            $result = $service->update([
                'name' => $inputData['name'],
                'price' => $inputData['price'],
                'available' => $inputData['status'],
            ]);
            return $result ? true : false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Delete an additional service by its ID.
     *
     * @param int $id The ID of the additional service to delete.
     * @return bool Returns true if the deletion is successful, otherwise false.
     */
    public function destroy(int $id): bool
    {
        try {
            $service = AdditionalService::findOrFail($id);
            $service->bookings()->detach();
            $service->delete();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

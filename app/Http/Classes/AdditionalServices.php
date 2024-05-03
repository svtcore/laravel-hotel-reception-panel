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
            $services = AdditionalService::all();
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
            $services = AdditionalService::where('available', 1)->get();
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
    
    public function store($inputData): bool
    {
        try{
            $result = AdditionalService::create([
                'name' => $inputData['name'],
                'price' => $inputData['price'],
                'available' => $inputData['status']
            ]);
            if ($result) return true;
            else return false;
        }
        catch(Exception $e){
            return false;
        }
    }

    public function getById(int $id): ?object
    {
        try{
            $service = AdditionalService::where('id', $id)->first();
            if ($service) return $service;
            else return null;
        }
        catch(Exception $e){
            return null;
        }
    }

    public function update($inputData, int $id): bool
    {
        try{
            $service = AdditionalService::findOrFail($id);
            $result = $service->update([
                'name' => $inputData['name'],
                'price' => $inputData['price'],
                'available' => $inputData['status']
            ]);
            if ($result) return true;
            else false;
        }
        catch(Exception $e){
            return false;
        }
    }

    public function destroy(int $id): bool
    {
        try{
            $service = AdditionalService::findOrFail($id);
            $service->bookings()->detach();
            $service->delete();
            return true;
        }
        catch(Exception $e){
            return false;
        }
    }
}

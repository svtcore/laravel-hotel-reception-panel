<?php

namespace App\Http\Classes;


use Exception;
use Illuminate\Support\Carbon;
use App\Models\AdditionalService;

class AdditionalServices
{
    /**
     * Retrieves available additional services.
     *
     * @return \Illuminate\Support\Collection|null A collection of available additional services or null if none are found.
     */
    public function getAvaliable(): ?iterable
    {
        try {
            $services = AdditionalService::where('avaliable', 1)->get();
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
}

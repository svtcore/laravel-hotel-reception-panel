<?php

namespace App\Http\Classes;


use Exception;
use Illuminate\Support\Carbon;
use App\Models\AdditionalService;

class AdditionalServices
{
    public function getAvaliable(): ?iterable
    {
        try{
            $services = AdditionalService::where('avaliable', 1)->get();
            if ($services && $services->count() > 0){
                return $services;
            }else return null;
        }
        catch(Exception $e){
            return null;
        }
    }
}


?>
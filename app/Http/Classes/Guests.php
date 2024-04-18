<?php

namespace App\Http\Classes;


use Exception;
use Illuminate\Support\Carbon;
use App\Models\CleaningLog;
use App\Models\Guest;
use PhpParser\Node\Expr;

class Guests
{
    public function getAll(): ?iterable
    {
        try{
            $guests = Guest::all();
            if ($guests && $guests->count() > 0) {
                return $guests;
            } else {
                return null;
            }
        }
        catch(Exception $e){
            return null;
        }
    }

    public function getLast($count): ?iterable
    {
        try{
            $guests = Guest::orderBy('id', 'desc')->take($count)->get();
            if ($guests && $guests->count() > 0) {
                return $guests;
            } else {
                return null;
            }
        }
        catch(Exception $e){
            return null;
        }
    }

    public function getById($id):?object
    {
        try{
            $guest = Guest::with('guest_document')->where('id', $id)->first();
            if ($guest && $guest->count() > 0) {
                return $guest;
            } else {
                return null;
            }
        }
        catch(Exception $e){
            return null;
        }
    }

    public function update($inputData, $id): bool
    {
        try{
            $guest = Guest::findOrFail($id);
            $result = $guest->update([
                'first_name' => $inputData['firstName'],
                'last_name' => $inputData['lastName'],
                'gender' => $inputData['gender'],
                'phone_number' => $inputData['phoneNumber'],
                'dob' => $inputData['dob'],
            ]);
            if ($result){
                $guest->guest_document->update([
                    'document_country' => $inputData['countryCode'],
                    'document_serial' => $inputData['documentSerial'],
                    'document_number' => $inputData['documentNumber'],
                    'document_expired' => $inputData['documentExpired'],
                    'document_issued_by' => $inputData['documentIssuedBy'],
                    'document_issued_date' => $inputData['documentIssuedDate'],
                ]);
                return true;
            }else return true;
        }
        catch(Exception $e){
            dd($e);
        }
    }

    public function deleteById($id): bool
    {
        try{
            $guest = Guest::findOrFail($id);
            $guest->bookings()->detach();
            $guest->delete();
            return true;
        }
        catch(Exception $e){
            dd($e);
        }
    }
}

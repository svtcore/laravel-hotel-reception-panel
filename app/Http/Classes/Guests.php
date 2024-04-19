<?php

namespace App\Http\Classes;


use Exception;
use Illuminate\Support\Carbon;
use App\Models\CleaningLog;
use App\Models\Guest;
use PhpParser\Node\Expr;
use App\Models\Booking;

class Guests
{
    public function getAll(): ?iterable
    {
        try {
            $guests = Guest::all();
            if ($guests && $guests->count() > 0) {
                return $guests;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    public function getLast($count): ?iterable
    {
        try {
            $guests = Guest::orderBy('id', 'desc')->take($count)->get();
            if ($guests && $guests->count() > 0) {
                return $guests;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    public function getById($id): ?object
    {
        try {
            $guest = Guest::with('guest_document')->where('id', $id)->first();
            if ($guest && $guest->count() > 0) {
                return $guest;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    public function update($inputData, $id): bool
    {
        try {
            $guest = Guest::findOrFail($id);
            $result = $guest->update([
                'first_name' => $inputData['firstName'],
                'last_name' => $inputData['lastName'],
                'gender' => $inputData['gender'],
                'phone_number' => $inputData['phoneNumber'],
                'dob' => $inputData['dob'],
            ]);
            if ($result) {
                $guest->guest_document->update([
                    'document_country' => $inputData['countryCode'],
                    'document_serial' => $inputData['documentSerial'],
                    'document_number' => $inputData['documentNumber'],
                    'document_expired' => $inputData['documentExpired'],
                    'document_issued_by' => $inputData['documentIssuedBy'],
                    'document_issued_date' => $inputData['documentIssuedDate'],
                ]);
                return true;
            } else return true;
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function deleteById($id): bool
    {
        try {
            $guest = Guest::findOrFail($id);
            $guest->bookings()->detach();
            $guest->delete();
            return true;
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function store($inputData): ?int
    {
        try {
            $result = Guest::create([
                'first_name' => $inputData['firstName'],
                'last_name' => $inputData['lastName'],
                'gender' => $inputData['gender'],
                'phone_number' => $inputData['phoneNumber'] ?? null,
                'dob' => $inputData['dob'],
            ]);
            $guest = Guest::findOrFail($result->id);
            if (isset($inputData['document_country'])) {
                $guest->guest_document()->create([
                    'document_country' => $inputData['countryCode'],
                    'document_serial' => $inputData['documentSerial'],
                    'document_number' => $inputData['documentNumber'],
                    'document_expired' => $inputData['documentExpired'],
                    'document_issued_by' => $inputData['documentIssuedBy'],
                    'document_issued_date' => $inputData['documentIssuedDate'],
                ]);
            }
            $booking = Booking::findOrFail($inputData['selectedOrderId']);
            $guest->bookings()->attach($booking);
            if ($result) {
                return $result->id;
            } else return null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function searchByParams(array $inputData, $trashed): ?iterable
    {
        try {
            $searchResult = Guest::with('guest_document');

            if (isset($inputData['guestName'])) {
                $guestName = $inputData['guestName'];
                $searchResult->where(function ($query) use ($guestName) {
                    $query->where('first_name', 'like', "%$guestName%")
                        ->orWhere('last_name', 'like', "%$guestName%");
                });
            } elseif (isset($inputData['firstName'])) {
                $firstName = $inputData['firstName'];
                $searchResult->where('first_name', 'like', "%$firstName%");
            } elseif (isset($inputData['lastName'])) {
                $lastName = $inputData['lastName'];
                $searchResult->where('last_name', 'like', "%$lastName%");
            }

            if (isset($inputData['phoneNumber'])) {
                $phoneNumber = $inputData['phoneNumber'];
                $searchResult->where('phone_number', '=', $phoneNumber);
            }

            $searchResult = $searchResult->orderBy('id', 'DESC')->get();

            if ($searchResult->count() > 0) {
                return $searchResult;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }
}

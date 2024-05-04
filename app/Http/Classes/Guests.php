<?php

namespace App\Http\Classes;


use Exception;
use Illuminate\Support\Carbon;
use App\Models\Guest;
use PhpParser\Node\Expr;
use App\Models\Booking;

class Guests
{
    /**
     * Retrieves all guests.
     *
     * @return \Illuminate\Database\Eloquent\Collection|null A collection of all guests, or null if no guests are found.
     */
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

    /**
     * Retrieves the last $count guests ordered by ID in descending order.
     *
     * @param int $count The number of last guests to retrieve.
     * @return \Illuminate\Database\Eloquent\Collection|null A collection of the last $count guests, or null if no guests are found.
     */
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

    /**
     * Retrieves a guest by their ID along with their associated guest document.
     *
     * @param int $id The ID of the guest to retrieve.
     * @return \App\Models\Guest|null The guest object with their associated guest document if found, or null if no guest with the specified ID is found.
     */
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

    /**
     * Updates a guest's information and their associated guest document.
     *
     * @param array $inputData An array containing the updated information for the guest.
     * @param int $id The ID of the guest to update.
     * @return bool True if the guest's information and associated guest document were successfully updated, false otherwise.
     */
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
            if ($result && isset($inputData['countryCode'])) {
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
            return false;
        }
    }

    /**
     * Deletes a guest by their ID, along with any bookings associated with them.
     *
     * @param int $id The ID of the guest to delete.
     * @return bool True if the guest and their associated bookings were successfully deleted, false otherwise.
     */
    public function deleteById($id): bool
    {
        try {
            $guest = Guest::findOrFail($id);
            $guest->bookings()->detach();
            $guest->delete();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Stores a new guest along with their associated guest document and booking (if provided).
     *
     * @param array $inputData An array containing the data for the new guest, including optional fields for guest document and booking.
     * @return int|null The ID of the newly created guest if successful, or null if an error occurred during creation.
     */
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
            if (isset($inputData['countryCode'])) {
                $guest->guest_document()->create([
                    'document_country' => $inputData['countryCode'],
                    'document_serial' => $inputData['documentSerial'],
                    'document_number' => $inputData['documentNumber'],
                    'document_expired' => $inputData['documentExpired'],
                    'document_issued_by' => $inputData['documentIssuedBy'],
                    'document_issued_date' => $inputData['documentIssuedDate'],
                ]);
            }
            if (isset($inputData['selectedOrderId']) && $inputData['selectedOrderId'] != 0) {
                $booking = Booking::findOrFail($inputData['selectedOrderId']);
                $guest->bookings()->attach($booking);
            }
            if ($result) {
                return $result->id;
            } else return null;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Searches for guests based on the provided search parameters.
     *
     * @param array $inputData An array containing the search parameters, such as guest name, first name, last name, and phone number.
     * @param bool $trashed Indicates whether to include trashed guests in the search.
     * @return \Illuminate\Support\Collection|null A collection of guest objects matching the search criteria, or null if no matching guests are found.
     */
    public function searchByParams(array $inputData, $trashed): ?iterable
    {
        try {
            $searchResult = Guest::with('guest_document');

            if (isset($inputData['guestName'])) {
                $guestName = $inputData['guestName'];
                $names = explode(' ', $guestName);
                if (count($names) == 2) {
                    $firstName = $names[0];
                    $lastName = $names[1];
                    $searchResult->where('first_name', 'like', "%" . $firstName . "%")
                        ->where('last_name', 'like', "%" . $lastName . "%");
                } else {
                    $searchResult->where(function ($query) use ($guestName) {
                        $query->where('first_name', 'like', "%" . $guestName . "%")
                            ->orWhere('last_name', 'like', "%" . $guestName . "%");
                    });
                }
            } elseif (isset($inputData['firstName'])) {
                $firstName = $inputData['firstName'];
                $searchResult->where('first_name', 'like', "%" . $firstName . "%");
            } elseif (isset($inputData['lastName'])) {
                $lastName = $inputData['lastName'];
                $searchResult->where('last_name', 'like', "%" . $lastName . "%");
            }

            if (isset($inputData['phoneNumber'])) {
                $phoneNumber = $inputData['phoneNumber'];
                $searchResult->where('phone_number', '=', $phoneNumber);
            }

            $searchResult = $searchResult->orderBy('id', 'DESC')->get();

            if ($searchResult->isNotEmpty()) {
                return $searchResult;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Retrieves a guest by their phone number.
     * If the guest is not found, creates a new guest entry with the provided details.
     *
     * @param array $inputData An array containing the guest's first name, last name, and phone number.
     * @return \App\Models\Guest|null The guest object retrieved or created based on the provided phone number, or null if an error occurs.
     */
    public function getByPhoneNumber($inputData): ?object
    {
        try {
            $guest = Guest::where('phone_number', $inputData['phoneNumber'])->first();
            if (isset($guest->id)) return $guest;
            else {
                $guest = Guest::create([
                    'first_name' => $inputData['firstName'],
                    'last_name' => $inputData['lastName'],
                    'phone_number' => $inputData['phoneNumber']
                ]);
                if (isset($guest->id)) return $guest;
                else return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Searches for guests based on their name.
     *
     * @param array $inputData An array containing the guest's name.
     * @return \Illuminate\Support\Collection|null A collection of guest objects matching the search criteria, or null if no guests are found or an error occurs.
     */
    public function searchRelationGuest($inputData)
    {
        try {
            $guest_data = explode(' ', $inputData['guestName']);
            if (count($guest_data) > 1) {
                $firstName = $guest_data[0];
                $lastName = $guest_data[1];

                $result = Guest::select(['id', 'first_name', 'last_name', 'dob'])->where("first_name", "like", "%" . $firstName . "%")
                    ->where("last_name", "like", "%" . $lastName . "%")->get();
                if ($result && $result->count() > 0) {
                    return $result;
                } else return null;
            } elseif (count($guest_data) == 1) {
                $name = $guest_data[0];
                $result = Guest::select(['id', 'first_name', 'last_name', 'dob'])
                    ->where("first_name", "like", "%" . $name . "%")
                    ->OrWhere("last_name", "like", "%" . $name . "%")->get();
                if ($result && $result->count() > 0) {
                    return $result;
                } else return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Submits a relation between a guest and a booking.
     *
     * @param array $inputData An array containing the related guest's ID and the booking ID.
     * @return bool True if the relation is successfully submitted, false otherwise.
     */
    public function submitRelation($inputData): bool
    {
        try {
            $guest_id = $inputData['related_guest_id'];
            $booking_id = $inputData['booking_id'];
            $booking = Booking::findOrFail($booking_id);

            if ($booking) {
                $booking->guests()->attach($guest_id);
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}

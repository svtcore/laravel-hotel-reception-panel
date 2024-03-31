<?php

namespace App\Http\Classes;


use Exception;
use Illuminate\Support\Carbon;
use App\Models\Room;
use PhpParser\Node\Expr;

class Rooms
{


    public function getFree(): ?iterable
    {
        try 
        {
            $rooms = Room::where('status', 'free')->get();
            if ($rooms->count() > 0) {
                return $rooms;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    public function getById($id): ?object
    {
        try 
        {
            $room = Room::findOrFail($id);
            return $room;
        } catch (Exception $e) {
            return null;
        }
    }

    public function searchByParams($validatednData): ?object
    {
        try{

        }
        catch(Exception $e){
            return null;
        }
    }
}

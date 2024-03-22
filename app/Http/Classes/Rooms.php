<?php

namespace App\Http\Classes;


use Exception;
use Illuminate\Support\Carbon;
use App\Models\Room;
use PhpParser\Node\Expr;

class Rooms{

    public function getById($id):?object
    {
        try{
            $room = Room::findOrFail($id);
            return $room;
        }
        catch(Exception $e){
            return null;
        }
    }
}
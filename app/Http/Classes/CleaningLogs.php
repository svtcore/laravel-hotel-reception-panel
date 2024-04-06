<?php

namespace App\Http\Classes;


use Exception;
use Illuminate\Support\Carbon;
use App\Models\CleaningLog;
use PhpParser\Node\Expr;

class CleaningLogs
{
    public function getByRoomId($room_id): ?iterable
    {
        try{
            $cleaning_log = CleaningLog::with(['staff'])->where('room_id', $room_id)->get();
            if ($cleaning_log->count() > 0) {
                return $cleaning_log;
            } else {
                return null;
            }
        }
        catch(Exception $e){
            return null;
        }
    }
}

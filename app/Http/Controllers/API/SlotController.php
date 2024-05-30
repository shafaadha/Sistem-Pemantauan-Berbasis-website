<?php

namespace App\Http\Controllers\API;

use App\Models\AccessLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public static function slotCount() {
        $slot = "100";
        $countIn = AccessLog::whereDate('date', now())->whereNotNull('time_masuk')->count();
        $countOut = AccessLog::whereDate('date', now())->whereNotNull('time_keluar')->count();
        $slotTersedia = $slot - ($countIn - $countOut);
    
   
        return response()->json(["Jumlah slot tersedia" => $slotTersedia]);
    }
}

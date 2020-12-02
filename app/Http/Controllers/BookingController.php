<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends ParentController
{
    public function getList(Request $request){
        $list = Booking::all();
        return response()->json(['success'=>$list], ParentController::$successCode);
    }
}

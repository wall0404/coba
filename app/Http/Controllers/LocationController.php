<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends ParentController
{
    protected $pagination = false;

    public function getList(Request $request) {

        $list = Location::with('workstations')->get();

        return response()->json(['success'=>$list], ParentController::$successCode);
    }
}

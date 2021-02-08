<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BestBuddiesController extends Controller
{
    /**
     * add a buddy
     *
     * @param  Request $request
     *
     */
    public function addBuddy(Request $request)
    {
        $id = $request->input() ;
        Auth::user()->UserIsBuddyOf()->attach($id);

        return response()->json(['success' => true], ParentController::$successCode);
    }

    /**
     * remove a buddy
     *
     * @param  Request $request
     * @return Response
     */
    public function removeBuddy(Request $request)
    {
        $id = $request->input() ;
        Auth::user()->UserIsBuddyOf()->detach($id);

        return response()->json(['success' => true], ParentController::$successCode);
    }
}

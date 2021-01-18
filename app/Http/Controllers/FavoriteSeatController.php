<?php

namespace App\Http\Controllers;

use App\Models\Workstation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteSeatController extends Controller
{
    /**
     * Favorite Seat
     *
     * @param  Request $request
     *
     */
    public function addFavoriteSeat(Request $request)
    {
        $id = $request->input() ;
        Auth::user()->favorites()->attach($id);

        return response()->json(['success' => true], ParentController::$successCode);
    }

    /**
     * Unfavorite a Seat
     *
     * @param  Request $request
     * @return Response
     */
    public function removeFavoriteSeat(Request $request)
    {
        $id = $request->input() ;
        Auth::user()->favorites()->detach($id);

        return response()->json(['success']) ;
    }


}

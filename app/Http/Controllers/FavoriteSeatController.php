<?php

namespace App\Http\Controllers;

use App\Models\Workstation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteSeatController extends Controller
{
    /**
     * Favorite Seat
     *
     * @param  Request $request
     * @return Response
     */
    public function favoriteSeat(Request $request)
    {
        $id = $request->input() ;
        Auth::user()->favorites()->attach($id);

        return response()->json(['success']) ;
    }

    /**
     * Unfavorite a Seat
     *
     * @param  Request $request
     * @return Response
     */
    public function unFavoriteSeat(Request $request)
    {
        $id = $request->input() ;
        Auth::user()->favorites()->detach($id);

        return response()->json(['success']) ;
    }
}

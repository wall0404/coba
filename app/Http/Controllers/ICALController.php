<?php

namespace App\Http\Controllers;

use App\Http\Classes\ICal;
use App\Models\Booking;
use App\Models\iCalAssignments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ICALController extends Controller
{
    public function getICal(Request $request, $token) {
        $ical = new ICal();

        //TODO get bookings
        $iCalAssignment = iCalAssignments::where('token', $token)->first();

        if(!isset($iCalAssignment))
            return response()->json(['error'=>ParentController::$notFoundText], ParentController::$notFoundCode);

        $bookings = Booking::where('user_id', $iCalAssignment->user_id)->orderBy('date')->get();




        foreach ($bookings as $booking) {
            $start = new Carbon($booking->date);
            $start->setHour(substr($booking->from, 0, 2));
            $start->setMinute(substr($booking->from, 2, 2));

            $end = new Carbon($booking->date);
            $end->setHour(substr($booking->to, 0, 2));
            $end->setMinute(substr($booking->to, 2, 2));

            $updated_at = new Carbon($booking->updated_at);

            if(isset($booking->workstation)) {
                $workstation = $booking->workstation->name . " - " . $booking->workstation->location->name;
            }
            else {
                $workstation = "Remote Work";
            }
            $ical->addEvent($booking->id, $start->format('Ymd\THis\Z'), $end->format('Ymd\THis\Z'), $workstation, "Sitzplatzbuchung", $updated_at->format('Ymd\THis\Z'));
        }

        return $ical->publish();
    }

    public function get() {
        $data = Auth::user()->ical;
        try {
            $data->url = route('ical', ['token' => $data->token]);
        }
        catch (\Exception $e) {}
        return response()->json(['success'=>$data], ParentController::$successCode);
    }
    public function create() {
        if(isset(Auth::user()->ical)) {
            $iCalAssignment = Auth::user()->ical;
        }
        else {
            while(true) {
                $token = Str::random(12);

                if(iCalAssignments::where('token', $token)->count() < 1)
                    break;
            }
            $iCalAssignment = Auth::user()->ical()->create([
                'token' => $token,
            ]);
        }
        $iCalAssignment->url = route('ical', ['token' => $iCalAssignment->token]);
        return response()->json(['success'=>$iCalAssignment], ParentController::$successCode);
    }
    public function delete() {
        try {
            Auth::user()->ical->delete();
        }
        catch (\Exception $e) {}
        return response()->json(['success'=>'true'], ParentController::$successCode);
    }
}

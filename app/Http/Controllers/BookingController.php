<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingController extends ParentController
{
    protected $pagination = false;
    protected $model_name = 'App\Models\Booking';

    protected $validator_create = [
        'user_id' => 'required',
//        'workstation_id' => 'required',
        'date' => 'date_format:Y-m-d|required'
    ];
    protected $validator_create_array = [
        '*.user_id' => 'required',
       // '*.workstation_id' => 'required',
        '*.date' => 'date_format:Y-m-d|required'
    ];
    protected $validator_update = [
        'date' => 'date'
    ];
    protected $filter = [
        'date' => 'gol',
        'from' => 'gol',
        'to' => 'gol',
        'user_id' => 'equals',
        'workstation' => 'equals',
        'location_id' => 'custom',
    ];

    protected function doBeforeCreated($input){
        if(empty($input['from']))
            $input['from'] = '09:00';
        if(empty($input['to']))
            $input['to'] = '17:00';

        if($input['from'] >= $input['to'])
            throw new \Exception('Startzeit darf nicht nach der Endzeit liegen');

        //Check if workplace is already taken by someone else
        if(isset($input['workstation_id'])) {
            $bookings = Booking::where('date', $input['date'])->where('workstation_id', $input['workstation_id'])->get();
            foreach ($bookings as $booking) {
                $booking_start = new Carbon($booking->from);
                $booking_end = new Carbon($booking->to);
                if ($booking_start->lt(new Carbon($input['to'])) && $booking_end->gt(new Carbon($input['from'])))
                    throw new \Exception('Platz ist zu dem Zeitpunkt schon vergeben');
            }
        }

        //Check if user already booked a workplace at this time
        $bookings = Booking::where('date', $input['date'])->where('user_id', Auth::id())->get();
        foreach ($bookings as $booking) {
            $booking_start = new Carbon($booking->from);
            $booking_end = new Carbon($booking->to);
            if($booking_start->lt(new Carbon($input['to']))  && $booking_end->gt(new Carbon($input['from']))) {
                if($booking->workstation_id == $input['workstation_id'])
                    throw new \Exception('Sie haben diesen Arbeitsplatz zu dieser Uhrzeit schon gebucht');
                else
                    throw new \Exception('Zu dieser Zeit haben sie schon einen anderen Arbeitsplatz gebucht.');
            }

        }

        //Check if date too far in the future
        // Create a new DateTime object from today
        $date = new Carbon();
        // Modify the date it contains
        $date->modify('next saturday');
        $date->modify('+14 days');
        $input_date = new Carbon($input['date']);
        if($input_date->gt($date))
            throw new \Exception("Datum liegt zu weit in der Zukunft. Bitte buche nur für die nächsten 2 Wochen");

        return $input;
    }

    protected function doBeforeUpdated($booking){

        if($booking->from >= $booking->to)
            throw new \Exception('Startzeit darf nicht nach der Endzeit liegen');

        //Check if workplace is already taken by someone else
        if(isset($input['workstation_id'])) {
            $bookings = Booking::where('date', $booking->date)->where('workstation_id', $booking->workstation_id)->whereNot('id', $booking->id)->get();
            foreach ($bookings as $booking) {
                $booking_start = new Carbon($booking->from);
                $booking_end = new Carbon($booking->to);
                if ($booking_start->lt(new Carbon($input['to'])) && $booking_end->gt(new Carbon($input['from'])))
                    throw new \Exception('Platz ist zu dem Zeitpunkt schon vergeben');
            }
        }

        //Check if user already booked a workplace at this time
        $bookings = Booking::where('date', $input['date'])->whereNot('id', $input['id'])->where('user_id', Auth::id())->get();
        foreach ($bookings as $booking) {
            $booking_start = new Carbon($booking->from);
            $booking_end = new Carbon($booking->to);
            if($booking_start->lt(new Carbon($input['to']))  && $booking_end->gt(new Carbon($input['from']))) {
                if($booking->workstation_id == $input['workstation_id'])
                    throw new \Exception('Sie haben diesen Arbeitsplatz zu dieser Uhrzeit schon gebucht');
                else
                    throw new \Exception('Zu dieser Zeit haben sie schon einen anderen Arbeitsplatz gebucht.');
            }

        }

        //Check if date too far in the future
        // Create a new DateTime object from today
        $date = new Carbon();
        // Modify the date it contains
        $date->modify('next saturday');
        $date->modify('+14 days');
        $input_date = new Carbon($input['date']);
        if($input_date->gt($date))
            throw new \Exception("Datum liegt zu weit in der Zukunft. Bitte buche nur für die nächsten 2 Wochen");

        return $input;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function create(Request $request) {
        //track models with validation error to ignore when inserting in db
        $validation_error = array();
        $returnObj = [
            "error" => [],
            "success" => []
        ];
        $data = array ();

        if($request->has('date') || $request->has('user_id') || $request->has('workstation_id')) {
            //only one booking given
            $data[0] = $request->input();
            //validate
            $validator = Validator::make($request->all(), $this->validator_create);
            if ($validator->fails()) {
                $validation_error = $validator->errors()->toArray();
            }
        }
        else {
            //array given
            $data = $request->json()->all();
            //validate
            $validator = Validator::make($request->all(), $this->validator_create_array);
            if ($validator->fails()) {
                $validation_error = $validator->errors()->toArray();
            }
        }

        //format validation errors
        foreach ($validation_error as $key => $error) {
            $index = $this->getNumberFromString($key);
            //$ignore_list[$index] = true;

            if(empty($returnObj['error'][$index])) {
                $data[$index]['error'] = array();
                $returnObj['error'][$index] = $data[$index];
            }

            $returnObj['error'][$index]['error'][] = $error[0];
        }

        foreach ($data as $key => $booking) {
            //check if it had validation errors and should get ignored

            if(!isset($returnObj['error'][$key])) {
                try {
                    $booking = $this->doBeforeCreated($booking);
                } catch (\Exception $e) {
                    $booking['error'][] = $e->getMessage();
                    $returnObj['error'][$key] = $booking;
                    continue;
                    //return response()->json(['error'=>$e->getMessage()], ParentController::$badRequestCode);
                }

                $model = new $this->model_name();
                foreach ($booking as $prop => $value) {
                    $model->$prop = $value;
                }

                if ($model->checkCreateRight()) {
                    $model->save();
                    $this->doAfterCreated($model);
                    $returnObj['success'][] = $model;
                } else {
                    $booking['error'][] = "Keine Berechtigung";
                    $returnObj['error'][$key] = $booking;
                    //return response()->json(['error'=>ParentController::$unauthorizedText], ParentController::$unauthorizedCode);
                }
            }
        }
        return response()->json($returnObj, ParentController::$successCode);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function update(Request $request, $id) {
        //track models with validation error to ignore when inserting in db
        $validation_error = array();
        $returnObj = [
            "error" => [],
            "success" => []
        ];
        $data = array ();

        if(true) {
            //only one booking given
            $data[0] = $request->input();
            //validate
            $validator = Validator::make($request->all(), $this->validator_update);
            if ($validator->fails()) {
                $validation_error = $validator->errors()->toArray();
            }
        }
        else {
            //array given
            return response()->json(['error'=>"Only update one booking at a time"], ParentController::$inputValidationErrorCode);

            // code is currently not used. could be used in the future for mass updating
            $data = $request->json()->all();
            //validate
            $validator = Validator::make($request->all(), $this->validator_create_array);
            if ($validator->fails()) {
                $validation_error = $validator->errors()->toArray();
            }
        }

        //format validation errors
        foreach ($validation_error as $key => $error) {
            $index = $this->getNumberFromString($key);
            //$ignore_list[$index] = true;

            if(empty($returnObj['error'][$index])) {
                $data[$index]['error'] = array();
                $returnObj['error'][$index] = $data[$index];
            }

            $returnObj['error'][$index]['error'][] = $error[0];
        }

        foreach ($data as $key => $booking) {
            //check if it had validation errors and should get ignored

            if(!isset($returnObj['error'][$key])) {
                try {
                    $model = Booking::findOrFail($id);

                    foreach ($booking as $prop => $value) {
                        $model->$prop = $value;
                    }

                    $booking = $this->doBeforeUpdated($booking);

                    if ($model->checkUpdateRight()) {
                        $model->save();
                        $returnObj['success'][] = $model;
                    }
                    else {
                        $booking['error'][] = "Keine Berechtigung";
                        $returnObj['error'][$key] = $booking;
                    }
                } catch (\Exception $e) {
                    $booking['error'][] = $e->getMessage();
                    $returnObj['error'][$key] = $booking;
                    continue;
                    //return response()->json(['error'=>$e->getMessage()], ParentController::$badRequestCode);
                }
            }
        }
        return response()->json($returnObj, ParentController::$successCode);
    }

    protected function location_id_filter($list, $value) {
        $list = $list->join('workstations', 'bookings.workstation_id', '=', 'workstations.id')->where('workstations.location_id', '=', $value);
        return $list;
    }



    private function getNumberFromString($str) {
        $array = str_split($str);
        $numberStr = "";
        foreach ($array as $char) {
            if(is_numeric($char))
                $numberStr .= ($char);
            else
                break;
        }
        return (int)$numberStr;
    }

}

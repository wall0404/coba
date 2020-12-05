<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Util\Exception;
use function PHPUnit\Framework\throwException;

class BookingController extends ParentController
{
    protected $pagination = false;
    protected $model_name = 'App\Models\Booking';

    protected $validator_create = [
        'user_id' => 'required',
        'workstation_id' => 'required',
        'date' => 'date_format:Y-m-d|required'
    ];
    protected $validator_create_array = [
        '*.user_id' => 'required',
        '*.workstation_id' => 'required',
        '*.date' => 'date_format:Y-m-d|required'
    ];
    protected $validator_update = [
        'user_id' => 'required',
        'workstation_id' => 'required',
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
            throw new Exception('Startzeit darf nicht nach der Endzeit liegen');

        //Check if workplace is already taken by someone else
        $bookings = Booking::where('date', $input['date'])->where('workstation_id', $input['workstation_id'])->get();
        foreach ($bookings as $booking) {
            if($booking->from <= $input['to'] && $booking->to >= $input['from'])
                throw new Exception('Platz ist zu dem Zeitpunkt schon vergeben');
        }

        return $input;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function create(Request $request) {
        //track models with validation error to ignore when inserting in db
        $ignore_list = array();
        $validation_error = null;
        $returnObj = [
            "error" => []
        ];
        $data = array ();

        if($request->has('date')) {
            //only one booking given
            $data[0] = $request->input();
            //validate
            $validator = Validator::make($request->all(), $this->validator_create);
            if ($validator->fails()) {
                $ignore_list[0] = true;
                $validation_error = $validator->errors()->toArray();

                $data[0]['error'] = array();

                foreach ($validation_error as $key => $error) {
                    $data[0]['error'][] = $error;
                }

                $returnObj['error']["0"] = $data[0];
            }


        }
        else {
            //array given
            $data = $request->json()->all();
            //validate
            $validator = Validator::make($request->all(), $this->validator_create_array);
            if ($validator->fails()) {
                $validation_error = $validator->errors()->toArray();
                foreach ($validation_error as $key => $error) {
                    $index = $this->getNumberFromString($key);
                    $ignore_list[$index] = true;

                    if(empty($returnObj['error'][$index])) {
                        $data[$index]['error'] = array();
                        $returnObj['error'][$index] = $data[$index];
                    }

                    $returnObj['error'][$index]['error'][] = $error;
                }
            }
        }
        return json_encode($returnObj);
        foreach ($data as $key => $booking) {
            try {
                $input = $this->doBeforeCreated($booking);
            }
            catch (\PHPUnit\Exception $e) {
                return response()->json(['error'=>$e->getMessage()], ParentController::$badRequestCode);
            }

            $model = new $this->model_name();
            foreach ($input as $key => $value) {
                $model->$key = $value;
            }

            if($model->checkCreateRight()) {
                $model->save();
                $this->doAfterCreated($model);
                return response()->json(['success' => $model], ParentController::$successCode);
            }
            else
                return response()->json(['error'=>ParentController::$unauthorizedText], ParentController::$unauthorizedCode);
        }
        exit($data);






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
        return number_format($numberStr);
    }

}

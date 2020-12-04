<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use PHPUnit\Util\Exception;
use function PHPUnit\Framework\throwException;

class BookingController extends ParentController
{
    protected $pagination = false;
    protected $model_name = 'App\Models\Booking';

    protected $validator_create = [
        'user_id' => 'required',
        'workstation_id' => 'required',
        'date' => 'date'
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
/*
    public function getList(Request $request){
        //Get input
        $input = $request->input();

        //load default limit and order values if not set in input parameters
        if (empty($input['limit'])) $input['limit'] = $this->default_limit;
        if (empty($input['order_by'])) $input['order_by'] = 'id';
        if (empty($input['order_desc'])) $input['order_desc'] = 0;

        $list = Booking::with(['workstation'])->whereNotNull('user_id');

        //filter
        if(isset($input['filter']['date'])) {
            if(!empty($input['filter']['user_id']))
                $list = $list->where('user_id', $input['filter']['user_id']);
            if(!empty($input['filter']['workstation_id']))
                $list = $list->where('workstation_id', $input['filter']['workstation_id']);
            if(!empty($input['filter']['location_id']))
                $list = $list->join('workstation', 'booking.workstation_id', '=', 'workstation.id')->where('workstation.location_id');
            if(!empty($input['filter']['date']['min']))
                $list = $list->where('date', '>=', $input['filter']['date']['min']);
            if(!empty($input['filter']['date']['max']))
                $list = $list->where('date', '<=', $input['filter']['date']['max']);
            if(!empty($input['filter']['time_from']['min']))
                $list = $list->where('from', '>=', $input['filter']['time_from']['min']);
            if(!empty($input['filter']['time_from']['max']))
                $list = $list->where('from', '<=', $input['filter']['time_from']['max']);
            if(!empty($input['filter']['time_to']['min']))
                $list = $list->where('to', '>=', $input['filter']['time_to']['min']);
            if(!empty($input['filter']['time_to']['max']))
                $list = $list->where('to', '<=', $input['filter']['time_to']['max']);
        }

        //order
        $list = $list->orderBy($input['order_by'], $input['order_desc']?'desc':'asc');

        //paginate list if wanted
        if($this->pagination)
            $list = $list->paginate($input['limit']);
        else
            $list = $list->get();

        return response()->json(['success'=>$list], ParentController::$successCode);
    }
*/

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

    protected function location_id_filter($list, $value) {
        $list = $list->join('workstations', 'bookings.workstation_id', '=', 'workstations.id')->where('workstations.location_id', '=', $value);
        return $list;
    }

}

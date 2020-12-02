<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends ParentController
{
    protected $pagination = false;

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
                $list = $list->where('location_id', $input['filter']['location_id']);
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
}

<?php

namespace App\Http\Controllers;

use App\Models\Workstation;
use Illuminate\Http\Request;

class WorkstationController extends ParentController
{
    protected $pagination = false;

    public function getList(Request $request) {
        //Get input
        $input = $request->input();

        //load default limit and order values if not set in input parameters
        if (empty($input['limit'])) $input['limit'] = $this->default_limit;
        if (empty($input['order_by'])) $input['order_by'] = 'id';
        if (empty($input['order_desc'])) $input['order_desc'] = 0;

        $list = Workstation::whereNotNull('id');

        //filter
        if(isset($input['filter']['location_id'])) {
            $list = $list->where('location_id', $input['filter']['location_id']);
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

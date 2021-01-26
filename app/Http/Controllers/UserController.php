<?php


namespace App\Http\Controllers;


use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends ParentController
{
    protected $model_name = 'App\User';
    protected $pagination = false;

    protected $validator_create = [
        'name' => 'required',
        'email' => 'nullable|email'
    ];
    protected $validator_update = [
        'name' => 'required',
        'email' => 'nullable|email'
    ];

    public function getInfo() {
        $data = [
            'user' => Auth::user(),
        ];
        return response()->json(['success'=>$data], ParentController::$successCode);
    }

    public function getList(Request $request) {
        //Get input
        $input = $request->input();

        //load default limit and order values if not set in input parameters
        if (empty($input['limit'])) $input['limit'] = $this->default_limit;
        if (empty($input['order_by'])) $input['order_by'] = 'user_id';
        if (empty($input['order_desc'])) $input['order_desc'] = 0;

        $list = User::whereNotNull('user_id');

        //filter

        //order
        $list = $list->orderBy($input['order_by'], $input['order_desc']?'desc':'asc');

        //paginate list if wanted
        if($this->pagination)
            $list = $list->paginate($input['limit']);
        else
            $list = $list->get();


        return response()->json(['success'=>$list], ParentController::$successCode);
    }

    public function getBookingList(Request $request, $id){
        //Get input
        $input = $request->input();

        //load default limit and order values if not set in input parameters
        if (empty($input['limit'])) $input['limit'] = $this->default_limit;
        if (empty($input['order_by'])) $input['order_by'] = 'id';
        if (empty($input['order_desc'])) $input['order_desc'] = 0;

        $list = Booking::with(['workstation'])->where('user_id', $id);

        //filter
        if(isset($input['filter']['date'])) {
            if(!empty($input['filter']['date']['min']))
                $list = $list->where('date', '>=', $input['filter']['date']['min']);
            if(!empty($input['filter']['date']['max']))
                $list = $list->where('date', '<=', $input['filter']['date']['max']);
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

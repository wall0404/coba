<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;

class UserController extends ParentController
{
    protected $model_name = 'App\User';

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
}

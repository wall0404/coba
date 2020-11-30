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
        return response()->json(['success'=>Auth::user()], ParentController::$successCode);
    }
}

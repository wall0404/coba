<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthController extends ParentController
{
    public function login(Request $request){
        if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], true)){
            $user = Auth::user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->save();
            $success['token'] =  $tokenResult->accessToken;
            $success['user'] = Auth::user();
            return response()->json(['success' => $success], ParentController::$successCode);
        }
        else{
            Auth::logout();
            return response()->json(['error'=>'Unauthorised'], ParentController::$unauthorizedCode);
        }
    }
}

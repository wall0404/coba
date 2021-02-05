<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthController extends ParentController
{
    public function login(Request $request){
        if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], true)){
            $user = Auth::user();
            $success['token'] =  $user->createToken('CobaToken')->accessToken;
            return response()->json(['success' => $success], ParentController::$successCode);
        }
        else{
            Auth::logout();
            return response()->json(['error'=>'Unauthorised'], ParentController::$unauthorizedCode);
        }
    }

    public function signup(Request $request)
    {
        Auth::logout();
        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], ParentController::$inputValidationErrorCode);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = new User();
        $user->password = $input['password'];
        $user->email = $input['email'];
        $user->firstName = $input['firstName'];
        $user->lastName = $input['lastName'];
        $user->save();
        $success['token'] =  $user->createToken('CobaToken')->accessToken;
        Auth::login($user);
        return response()->json(['success'=>$success], ParentController::$successCode);
    }

    public function logout() {
        Auth::logout();
        return response()->json(['success' => 'true'], ParentController::$successCode);
    }

    public function resetPassword(Request $request){
        if(Auth::check() && Auth::guard('web')->attempt(['email' => Auth::user()->email, 'password' => $request->input('password')], true)){
            $input = $request->all();
            $input['new_password'] = bcrypt($input['new_password']);
            $user = Auth::user();
            $user->password = $input['new_password'];
            $user->save();
            return response()->json(['success' => 'true'], ParentController::$successCode);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], ParentController::$unauthorizedCode);
        }
    }
}

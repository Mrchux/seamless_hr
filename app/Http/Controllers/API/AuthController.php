<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request){

        $rules =  [
            'email' => ['required', 'email', 'unique:users'],
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'name' => 'required'
        ];

        //Added this to validation error back in json format.
        $msg = $this->validateRequest($request, $rules);

        if(isset($msg)) {
            return response()->json(['status' => false, 'message' =>$msg, 'data' => []], 422);
        }


        $user = User::create([
            'name' => 'required',
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('seamless_hr', ['user'])->accessToken;

        return response()->json(['status' => true, 'message' =>'You have successfully registered', 'data' => $token], 200);
    }

    public function login(Request $request){
        $rules = [
            'email' => 'required',
            'password' => 'required',
        ];
        $msg = $this->validateRequest($request, $rules);

        if(isset($msg))
            return response()->json(['status' => false, 'message' =>$msg, 'data' => []], 422);

        $user = User::where('email', '=', $request->email)->first();

        if(!empty($user)){
            if(Hash::check($request->password, $user->password)){

                $token = $user->createToken('seamless_hr', ['user'])->accessToken;

                return response()->json(['status' => true, 'message' => 'Login successful', 'data' => $token], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Password is invalid', 'data' => []], 401);
            }

        } else
            return response()->json(['status' => false, 'message' => 'Login credentials do not match any record.', 'data' => []], 401);
    }


}

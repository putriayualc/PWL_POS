<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //get credentials from request
        $credentials = $request->only('username','password');

        //if auth failed
        if(!$token = auth()->guard('api')->attempt($credentials)){
            return response()->json([
                'success'=>false,
                'message'=>'Username atau Password Anda salah'
            ], 401);
        }else if(auth()->attempt($credentials)){//if auth success
            return response()->json([
                'success' => true,
                'user' => auth()->user(),
                'token' => $token
            ], 200);
        }

    }
}

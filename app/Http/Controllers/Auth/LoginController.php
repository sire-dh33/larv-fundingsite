<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unrecognized Email or Password'], 401);
        }

        
        return $this->createNewToken($token);
    }
    
    protected function createNewToken($token){

        $data['token'] = $token;
        $data['user'] = auth()->user();

        return response()->json([
            'response_code' => '00',
            'response_message' => 'User logged in successfully',
            'data' => $data,
        ], 200);
    }

}

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
        // $request->validate([
        //     'email' => 'required',
        //     'password' => 'required',
        // ]);

        // $credentials = $request->only(['email', 'password']);

        // if (! $token = auth()->attempt($credentials)) {
            //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        // $data['token'] = $token;
        // $data['user'] = auth()->user();
        
        // return response()->json([
        //     'response_code' => '00',
        //     'response_message' => 'User has successfully logged in',
        //     'data' => $data,
                
        // ], 200);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        
        return $this->createNewToken($token);

    }

    protected function createNewToken($token){
        return response()->json([
            'message' => 'You are successfully logged in',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Events\UserRegistered;
use Illuminate\Http\Request;
use App\Models\User;

class RegenerateOtpController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        
        // Panggil Method Generate OTP Codenya
        $user->generate_otp_code();

        event(new UserRegistered($user, 'regenerate'));

        $data['user'] = $user;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'New OTP Code has been successfully regenerated, Please check your Email',
            'data' => $data
        ]);
    }
}

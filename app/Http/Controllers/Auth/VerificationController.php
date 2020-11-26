<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OtpCode;
use App\Models\User;
use Carbon\Carbon;

class VerificationController extends Controller
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
            'otp' => 'required',
        ]);

        $otp_code = OtpCode::where('otp', $request->otp)->first();
        
        if (!$otp_code){
            return response()->json([
                'response_code' => '01',
                'response_message' => 'OTP Code not found',
            ], 200);
        }

        $now = Carbon::now();

        if ($now > $otp_code->valid_until) {
            return response()->json([
                'response_code' => '01',
                'response_message' => 'OTP Code has expired, please Regenerate'
            ], 200);
        }

        // Update User
        $user = User::find($otp_code->user_id);
        $user->email_verified_at = Carbon::now();
        $user->save();

        // Delete OTP
        $otp_code->delete();

        $data['user'] = $user;
        
        return response()->json([
            'response_code' => '00',
            'response_message' => 'User has been verified successfully',
            'data' => $data
        ]);
    }
}

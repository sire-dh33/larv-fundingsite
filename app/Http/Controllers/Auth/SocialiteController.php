<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Carbon\Carbon;
use App\Models\User;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider) 
    {
        $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();

        return response()->json([
            'url' => $url,
        ]);
    }

    public function handleProviderCallback($provider)
    {
        try {
            $social_user = Socialite::driver($provider)->stateless()->user();

            if (!$social_user) {
                return response()->json([
                    'response_code' => '01',
                    'response_message' => 'Login Failed',
                ], 401);
            }

            $user = User::whereEmail($social_user->email)->first();
            
            if( $user ) {
                // update the avatar and name that might have changed
                $user->update([
                    'photo_profile' => $social_user->avatar,
                    'name' => $social_user->name,
                ]);
            } else {
                
                if($social_user->email){ //Check email exists or not. If exists create a new user
                    $user = User::create(array_merge(
                        ['name' => $social_user->name,
                        'email' => $social_user->email,
                        'photo_profile' => $social_user->avatar,
                        'password' => '123456' // user can use reset password to create a password
                    ],
                ));
                $user->email_verified_at = Carbon::now();
                $user->save();
                
                } else {
                    return response()->json([
                        'response_code' => '01',
                        'response_message' => 'Failed to login',
            
                    ], 401);
                }
            }
                
            $data['user'] = $user;
            $data['token'] = auth()->login($user);
            
            return response()->json([
                'response_code' => '00',
                'response_message' => 'User logged in successfully',
                'data' => $data,
            ], 200);

        } catch (\Throwable $th) {
            
            return response()->json([
                'response_code' => '01',
                'response_message' => 'Login Failed',

            ], 401);
        }
    }
}

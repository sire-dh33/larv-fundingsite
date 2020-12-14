<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
    'namespace' => 'App\Http\Controllers\Auth'
    
], function(){
    Route::post('register' , 'RegisterController');
    Route::post('regenerate-otp', 'RegenerateOtpController');
    Route::post('verification', 'VerificationController');
    Route::post('update-password', 'UpdatePasswordController');
    Route::post('login', 'LoginController');
    Route::post('logout', 'LogoutController')->middleware('auth:api');
    Route::post('check-token', 'CheckTokenController')->middleware('auth:api');

    Route::get('/social/{provider}', 'SocialiteController@redirectToProvider');
    Route::get('/social/{provider}/callback', 'SocialiteController@handleProviderCallback');
});

Route::group([
    'middleware' => ['api', 'email_verified', 'auth:api'],
    'namespace' => 'App\Http\Controllers'
], function(){
    
    Route::get('profile/show', 'ProfileController@show');
    Route::post('profile/update', 'ProfileController@update');
    
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'campaign',
    'namespace' => 'App\Http\Controllers'
], function () {
    Route::get('random/{count}' , 'CampaignController@random');
    Route::post('store' , 'CampaignController@store');
    Route::get('/' , 'CampaignController@index');
    Route::get('/{id}' , 'CampaignController@detail');
    Route::get('/search/{keyword}', 'CampaignController@search');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'blog',
    'namespace' => 'App\Http\Controllers'
], function () {
    Route::get('random/{count}' , 'BlogController@random');
    Route::post('store' , 'BlogController@store');
});
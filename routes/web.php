<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/route-1', function(){
      return 'Sampel Halaman Route 1';
    })->middleware(['auth' , 'email_verified']);
    
    Route::get('/route-2', function(){
      return 'Sampel Halaman Route 2';
    })->middleware(['auth' , 'email_verified' , 'is_admin']);
    
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleSocialiteController;

use App\Http\Controllers\IcamController;
use App\Http\Controllers\CardController;

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

Route::get('/razor_pay_form', [App\Http\Controllers\Razorpay::class, 'razor_pay_form']);
Route::post('/razor_pay_submit', [App\Http\Controllers\Razorpay::class, 'razor_pay_submit']);
Route::post('/razor_pay_submit_next', [App\Http\Controllers\Razorpay::class, 'razor_pay_submit_next']);

Route::post('/razor_pay_return', [App\Http\Controllers\Razorpay::class, 'razor_pay_return']);


Route::get('/lara_form', [App\Http\Controllers\Lara::class, 'lara_form']);

Route::get('/snapshot', [App\Http\Controllers\Firebase::class, 'snapshot']);
Route::get('/save', [App\Http\Controllers\Firebase::class, 'save']);
Route::get('/update_specific_field', [App\Http\Controllers\Firebase::class, 'update_specific_field']);


// chat
// Route::group(['middleware' => 'web'], function () {
//     Route::auth();
//     Route::get('/chat', 'HomeController@index');
// });

Route::group(['middleware' => 'auth'], function () {
    Route::get('/chat', [App\Http\Controllers\HomeController::class,'chat']);
});
// Route::post('sendmessage', [App\Http\Controllers\HomeController::class,'sendMessage']);
Auth::routes();
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('fire', function () {
    // this fires the event
    event(new App\Events\ChatEvent());
    return "event fired";
});



// ===================== real time table with pusher =============

Route::middleware('auth')->get('cards', [CardController::class,'index']);
Route::middleware('auth')->name('card')->get('/cards/{card}', [CardController::class,'show']);

Route::get('leaderboard', [CardController::class,'leaderboard']);


// ========== social login =======================================

// google ---------------------

Route::get('auth/google', [GoogleSocialiteController::class, 'redirectToGoogle']);
Route::get('callback/google', [GoogleSocialiteController::class, 'handleCallback']);


// =============== for I cam DB =============
Route::get('convert_ref_email_to_new', [IcamController::class,'convert_ref_email_to_new'])->name('convert_ref_email_to_new');
Route::get('remove_duplicate_trafficesource/{start}', [IcamController::class,'remove_duplicate_trafficesource'])->name('trafficesource');
Route::get('remove_duplicate_info/{start}', [IcamController::class,'remove_duplicate_info'])->name('info');
Route::get('remove_duplicate_model_log_in/{start}', [IcamController::class,'remove_duplicate_model_log_in'])->name('model_log_in');

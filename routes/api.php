<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
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

// php artisan serve --host 192.168.2.92 --port 80


Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

// route for product controller
Route::resource('products', ProductsController::class);
// route for user controller
Route::resource('users', UserController::class);


// login a user
Route::post('/login', function(Request $request){

    $credentials = $request->only(['email', 'password']);

    // attempt works even tho it says undefined
    $token = auth('api')->attempt($credentials);

    if(!$token){
       abort(404, 'Invalid Credentials'); 
    }

    return $token;

});

// returns logged in user
Route::middleware('auth:api')->get('/me', function(){
    return auth()->user();
});


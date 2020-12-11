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
Route::resource('products', ProductsController::class);
Route::resource('users', UserController::class);

// Route::resource('users', UserController::class);


Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});


// create a user
Route::post('/user-create', function(Request $request, $id){
    App\Models\User::create([
        'name' => $request['name'],
        'email' => $request['email'],
        'password' => Hash::make($request['password'])
    ]);
});
// create a user
Route::put('/user-update/{id}', function(Request $request, $id){
        // update a user
        $user = App\Models\User::find($id);
        $user->update($request->all());

        return $user;

});

// login a suer
Route::post('/login', function(Request $request){

    $credentials = $request->only(['email', 'password']);

    // attempt works even tho it says undefined
    $token = auth('api')->attempt($credentials);

    if(!$token){
       abort(404, 'Invalid Credentials'); 
    }

    return $token;

});

Route::middleware('auth:api')->get('/me', function(){
    return auth()->user();
});

// logout a user
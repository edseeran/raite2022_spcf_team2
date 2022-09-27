<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//ACCOUNT API ROUTES
Route::group([
    'prefix' => 'account'

], function ($route) {

$route->post('/register',                   [UserController::class,'register']);
$route->post('/login',                      [UserController::class,'login']);
   
    Route::group([ 
    'middleware' => 'auth:sanctum',

], function ($route) {
    $route->post('/logout',                  [UserController::class,'logout']);
    $route->get('/list',                     [UserController::class,'list']);
    $route->get('/show/{applicant_id}',      [UserController::class,'show']);
    $route->delete('/delete/{applicant_id}', [UserController::class,'delete']);
    $route->put('/update/{applicant_id}',    [UserController::class,'update']);
});
});
<?php

use App\Events\NewMessage;
use App\Events\CustomEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginSignUpController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\MessageController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['protectedApi']], function () {
    Route::post('createUser', [UserController::class, 'create']);
    Route::post('updateUser', [UserController::class, 'update']);
    Route::post('deleteUser', [UserController::class, 'delete']);

    Route::post('viewTodo', [TodoController::class, 'view']);
    Route::post('createTodo', [TodoController::class, 'create']);
    Route::post('updateTodo', [TodoController::class, 'update']);
    Route::post('completeTodo', [TodoController::class, 'complete']);
    Route::post('deleteTodo', [TodoController::class, 'delete']);
});

Route::post('/login', [LoginSignUpController::class, 'login']);
Route::post('/signup', [LoginSignUpController::class, 'signup']);
//Route::post('/lol', [LoginSignUpController::class, 'lol']);

Route::get('/get-chat-room', [MessageController::class, 'getChatRoom']);
Route::get('/send-message', [MessageController::class, 'sendMessage']);
Route::get('/get-message', [MessageController::class, 'getMessage']);
Route::get('/yo', [MessageController::class, 'yo']);

Route::get('/lol', function (Request $request) {
    event(new CustomEvent($request->input('message')));
});






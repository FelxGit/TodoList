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



Route::group(['middleware' => 'auth:api'], function(){  // or if user has token

    Route::post('todos', 'API\TodoListController@addTodo');
    Route::get('todos', 'API\TodoListController@index');
    Route::put('todos/{id}', 'API\TodoListController@updateTodo');
    Route::delete('todos/{id}', 'API\TodoListController@removeTodo');
});
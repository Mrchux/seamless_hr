<?php

use Illuminate\Http\Request;

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

//Authentication & Register
Route::post('/register', 'API\AuthController@register');
Route::post('/login', 'API\AuthController@login');

Route::get('/courses/create', 'API\CoursesController@createCourses');



Route::group(['middleware' =>  'auth:api'], function(){
    Route::get('/courses/list', 'API\CoursesController@listCourses');
    Route::get('/courses/export', 'API\CoursesController@exportCourses');
    Route::post('/courses/register', 'API\CoursesController@registerCourse');
});

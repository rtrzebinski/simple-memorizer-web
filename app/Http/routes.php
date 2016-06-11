<?php

/*
 |--------------------------------------------------------------------------
 | Application Routes
 |--------------------------------------------------------------------------
 |
 | Here is where you can register all of the routes for an application.
 | It's a breeze. Simply tell Laravel the URIs it should respond to
 | and give it the controller to call when that URI is requested.
 |
 */

Route::post('/api/signup', 'Api\UserController@signup');
Route::post('/api/login', 'Api\UserController@login');

Route::group(['middleware' => ['auth:api', 'throttle:60,1']], function () {
    Route::get('/exercises/{exercise_id}', 'Api\ExerciseController@fetchExercise');
    Route::patch('/exercises/{exercise_id}', 'Api\ExerciseController@updateExercise');
    Route::delete('/exercises/{exercise_id}', 'Api\ExerciseController@deleteExercise');
    Route::get('/exercises', 'Api\ExerciseController@fetchExercisesOfUser');
    Route::post('/exercises', 'Api\ExerciseController@createExercise');
});

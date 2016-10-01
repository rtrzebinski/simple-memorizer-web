<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
| All api routes has '/api/' url prefix defined in RouteServiceProvider.
|
*/

Route::post('/register', 'Api\RegisterController@register');

Route::post('/login', 'Api\LoginController@login');

Route::group(['middleware' => ['auth:api', 'throttle:60,1']], function () {

    Route::post('/lessons', 'Api\LessonController@createLesson');

    Route::get('/lessons/owned', 'Api\LessonController@fetchOwnedLessons');

    Route::post('/lessons/{lesson}/user', 'Api\LessonController@subscribeLesson');

    Route::delete('/lessons/{lesson}/user', 'Api\LessonController@unsubscribeLesson');

    Route::get('/lessons/subscribed', 'Api\LessonController@fetchSubscribedLessons');

    Route::get('/lessons/{lesson}', 'Api\LessonController@fetchLesson');

    Route::patch('/lessons/{lesson}', 'Api\LessonController@updateLesson');

    Route::delete('/lessons/{lesson}', 'Api\LessonController@deleteLesson');

    Route::post('/lessons/{lesson}/exercises', 'Api\ExerciseController@createExercise');

    Route::get('/exercises/{exercise}', 'Api\ExerciseController@fetchExercise');

    Route::get('/lessons/{lesson}/exercises', 'Api\ExerciseController@fetchExercisesOfLesson');

    Route::patch('/exercises/{exercise}', 'Api\ExerciseController@updateExercise');

    Route::delete('/exercises/{exercise}', 'Api\ExerciseController@deleteExercise');

    Route::get('/lessons/{lesson}/exercises/random', 'Api\ExerciseController@fetchRandomExerciseOfLesson');

    Route::post('/exercises/{exercise}/increase-number-of-good-answers-of-user',
        'Api\ExerciseController@increaseNumberOfGoodAnswersOfUser');

    Route::post('/exercises/{exercise}/increase-number-of-bad-answers-of-user',
        'Api\ExerciseController@increaseNumberOfBadAnswersOfUser');

});

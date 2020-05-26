<?php

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

// Route::get('/', function () {
//     return view('questions.index');
// });

Auth::routes();

Route::get('/', 'QuestionsController@index')->name('home');

Route::resource('questions', 'QuestionsController')->except('show'); 

Route::get('questions/{slug}', 'QuestionsController@show')->name('questions.show'); 

Route::resource('questions/{question}/answers', 'AnswersController');

Route::post('questions/{question}/answers/{answer}/best-answer', 'AnswersController@markBestAnswer');

Route::post('questions/{question}/add-favorites', 'QuestionsController@markFavorited');

Route::delete('questions/{question}/delete-favorites', 'QuestionsController@unmarkFavorited');

Route::post('questions/{question}/vote', 'QuestionsController@vote');

Route::post('answers/{answer}/vote', 'AnswersController@vote');


<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('home', 'HomeController@index')->name('home');

Route::get('videos/{video}', 'VideoController@show');

Route::post('videos/{video}/views', 'VideoViewController@create');

Route::get('search', 'SearchController@index');

Route::get('videos/{video}/votes', 'VideoVoteController@show');

Route::get('videos/{video}/comments', 'VideoCommentController@index');

Route::get('subcription/{channel}', 'ChannelSubcriptionController@show');

Route::get('channels/{channel}', 'ChannelController@show');

Route::group(['middleware' => ['auth']], function () {
    Route::get('channels/{channel}/edit', 'ChannelSettingsController@edit');
    Route::post('channels/{channel}/edit', 'ChannelSettingsController@update');

    Route::get('upload', 'VideoUploadController@index');
    Route::post('upload', 'VideoUploadController@store');

    Route::get('videos', 'VideoController@index');
    Route::get('videos/{video}/edit', 'VideoController@edit');
    Route::post('videos', 'VideoController@store');
    Route::post('videos/{video}', 'VideoController@update');
    Route::post('videos/{video}/delete', 'VideoController@delete');
    Route::post('videos/{video}/comments', 'VideoCommentController@create');
    Route::delete('videos/{video}/comments/{comment}', 'VideoCommentController@delete');

    Route::post('videos/{video}/votes', 'VideoVoteController@create');
    Route::delete('videos/{video}/votes', 'VideoVoteController@remove');

    Route::post('subcriptions/{channel}', 'ChannelSubcriptionController@create');
    Route::delete('subcriptions/{channel}', 'ChannelSubcriptionController@delete');
});
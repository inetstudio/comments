<?php

Route::group(['namespace' => 'InetStudio\Comments\Controllers'], function () {
    Route::group(['middleware' => 'web', 'prefix' => 'back'], function () {
        Route::group(['middleware' => 'back.auth'], function () {
            Route::post('comments/activity/{id}', 'CommentsController@changeActivity')->name('back.comments.activity');
            Route::any('comments/data', 'CommentsController@data')->name('back.comments.data');
            Route::resource('comments', 'CommentsController', ['except' => [
                'show', 'create', 'store',
            ], 'as' => 'back']);
        });
    });
});

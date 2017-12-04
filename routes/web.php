<?php

Route::group(['namespace' => 'InetStudio\Comments\Http\Controllers\Back'], function () {
    Route::group(['middleware' => 'web', 'prefix' => 'back'], function () {
        Route::group(['middleware' => 'back.auth'], function () {
            Route::post('comments/activity/{id}', 'CommentsController@changeActivity')->name('back.comments.activity');
            Route::any('comments/data', 'CommentsController@data')->name('back.comments.data');
            Route::post('comments/group/activity', 'CommentsController@groupActivity')->name('back.comments.group.activity');
            Route::post('comments/group/read', 'CommentsController@groupRead')->name('back.comments.group.read');
            Route::post('comments/group/destroy', 'CommentsController@groupDestroy')->name('back.comments.group.destroy');
            Route::get('comments/answer/{id}', 'CommentsController@answer')->name('back.comments.answer');
            Route::resource('comments', 'CommentsController', ['except' => [
                'show', 'create',
            ], 'as' => 'back']);
        });
    });
});

Route::group(['namespace' => 'InetStudio\Comments\Http\Controllers\Front'], function () {
    Route::group(['middleware' => 'web'], function () {
        Route::post('comments/more/{type}/{id}', 'CommentsController@getComments')->name('front.comments.get');
        Route::post('comments/{type}/{id}', 'CommentsController@sendComment')->name('front.comments.send');
    });
});

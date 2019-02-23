<?php

Route::group([
    'namespace' => 'InetStudio\Comments\Contracts\Http\Controllers\Back',
    'middleware' => ['web', 'back.auth'],
    'prefix' => 'back',
], function () {
    Route::any('comments/data', 'CommentsDataControllerContract@data')->name('back.comments.data.index');

    Route::post('comments/moderate/activity', 'CommentsModerateControllerContract@activity')->name('back.comments.moderate.activity');
    Route::post('comments/moderate/read', 'CommentsModerateControllerContract@read')->name('back.comments.moderate.read');
    Route::post('comments/moderate/destroy', 'CommentsModerateControllerContract@destroy')->name('back.comments.moderate.destroy');

    Route::resource('comments', 'CommentsControllerContract', [
        'as' => 'back',
    ]);
});

Route::group(['namespace' => 'InetStudio\Comments\Contracts\Http\Controllers\Front'], function () {
    Route::group(['middleware' => 'web'], function () {
        Route::post('comments/more/{type}/{id}', 'CommentsControllerContract@getComments')->name('front.comments.get');
        Route::post('comments/{type}/{id}', 'CommentsControllerContract@sendComment')->name('front.comments.send');
    });
});

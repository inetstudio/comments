<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'InetStudio\CommentsPackage\Comments\Contracts\Http\Controllers\Back',
        'middleware' => ['web', 'back.auth'],
        'prefix' => 'back',
    ],
    function () {
        Route::any('comments/data', 'DataControllerContract@data')
            ->name('back.comments.data.index');

        Route::post('comments/moderate/activity', 'ModerateControllerContract@activity')
            ->name('back.comments.moderate.activity');
        Route::post('comments/moderate/read', 'ModerateControllerContract@read')
            ->name('back.comments.moderate.read');
        Route::post('comments/moderate/destroy', 'ModerateControllerContract@destroy')
            ->name('back.comments.moderate.destroy');

        Route::resource(
            'comments',
            'ResourceControllerContract',
            [
                'as' => 'back',
            ]
        );
    }
);

Route::group(
    [
        'namespace' => 'InetStudio\CommentsPackage\Comments\Contracts\Http\Controllers\Front',
        'middleware' => ['web'],
    ],
    function () {
        Route::post('comments/more/{type}/{id}', 'ItemsControllerContract@getitems')
            ->name('front.comments.get');
        Route::post('comments/{type}/{id}', 'ItemsControllerContract@send')
            ->name('front.comments.send');
    }
);

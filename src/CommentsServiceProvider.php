<?php

namespace InetStudio\Comments;

use Illuminate\Support\ServiceProvider;
use InetStudio\Comments\Models\CommentModel;
use InetStudio\Comments\Observers\CommentObserver;

class CommentsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../public' => public_path(),
        ], 'public');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'admin.module.comments');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->publishes([
            __DIR__.'/../config/comments.php' => config_path('comments.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            if (! class_exists('CreateCommentsTables')) {
                $timestamp = date('Y_m_d_His', time());
                $this->publishes([
                    __DIR__.'/../database/migrations/create_comments_tables.php.stub' => database_path('migrations/'.$timestamp.'_create_comments_tables.php'),
                ], 'migrations');
            }

            $this->commands([
                Commands\SetupCommand::class,
            ]);
        }

        view()->composer('admin.module.comments::includes.navigation', function($view) {
            $view->with('unreadBadge', CommentModel::unread()->count());
        });

        CommentModel::observe(CommentObserver::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}

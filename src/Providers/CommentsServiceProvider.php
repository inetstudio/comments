<?php

namespace InetStudio\Comments\Providers;

use Illuminate\Support\ServiceProvider;
use InetStudio\Comments\Models\CommentModel;
use InetStudio\Comments\Observers\CommentObserver;
use InetStudio\Comments\Console\Commands\SetupCommand;

class CommentsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerConsoleCommands();
        $this->registerPublishes();
        $this->registerRoutes();
        $this->registerViews();
        $this->registerObservers();
        $this->registerViewComposers();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Register Comments's console commands.
     *
     * @return void
     */
    protected function registerConsoleCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SetupCommand::class,
            ]);
        }
    }

    /**
     * Setup the resource publishing groups for Subscription.
     *
     * @return void
     */
    protected function registerPublishes(): void
    {
        $this->publishes([
            __DIR__.'/../../public' => public_path(),
        ], 'public');

        $this->publishes([
            __DIR__.'/../../config/comments.php' => config_path('comments.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            if (! class_exists('CreateCommentsTables')) {
                $timestamp = date('Y_m_d_His', time());
                $this->publishes([
                    __DIR__.'/../../database/migrations/create_comments_tables.php.stub' => database_path('migrations/'.$timestamp.'_create_comments_tables.php'),
                ], 'migrations');
            }
        }
    }

    /**
     * Register Comments's routes.
     *
     * @return void
     */
    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
    }

    /**
     * Register Comments's views.
     *
     * @return void
     */
    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'admin.module.comments');
    }

    /**
     * Register Comments's observers.
     *
     * @return void
     */
    public function registerObservers(): void
    {
        CommentModel::observe(CommentObserver::class);
    }

    /**
     * Register Comments's view composers.
     *
     * @return void
     */
    public function registerViewComposers(): void
    {
        view()->composer('admin.module.comments::includes.navigation', function($view) {
            $view->with('unreadBadge', CommentModel::unread()->count());
        });
    }
}

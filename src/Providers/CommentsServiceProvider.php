<?php

namespace InetStudio\Comments\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use InetStudio\Comments\Models\CommentModel;
use InetStudio\Comments\Observers\CommentObserver;
use InetStudio\Comments\Events\Back\ModifyCommentEvent;
use InetStudio\Comments\Services\Front\CommentsService;
use InetStudio\Comments\Listeners\ClearCommentsCacheListener;
use InetStudio\Comments\Listeners\AttachUserToCommentsListener;

/**
 * Class CommentsServiceProvider.
 */
class CommentsServiceProvider extends ServiceProvider
{
    /**
     * Загрузка сервиса.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerConsoleCommands();
        $this->registerPublishes();
        $this->registerRoutes();
        $this->registerViews();
        $this->registerTranslations();
        $this->registerEvents();
        //$this->registerObservers();
        $this->registerViewComposers();
    }

    /**
     * Регистрация привязки в контейнере.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerBindings();
    }

    /**
     * Регистрация команд.
     *
     * @return void
     */
    protected function registerConsoleCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                'InetStudio\Comments\Console\Commands\SetupCommand',
            ]);
        }
    }

    /**
     * Регистрация ресурсов.
     *
     * @return void
     */
    protected function registerPublishes(): void
    {
        $this->publishes([
            __DIR__.'/../../config/comments.php' => config_path('comments.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            if (! Schema::hasTable('comments')) {
                $timestamp = date('Y_m_d_His', time());
                $this->publishes([
                    __DIR__.'/../../database/migrations/create_comments_tables.php.stub' => database_path('migrations/'.$timestamp.'_create_comments_tables.php'),
                ], 'migrations');
            }
        }
    }

    /**
     * Регистрация путей.
     *
     * @return void
     */
    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
    }

    /**
     * Регистрация представлений.
     *
     * @return void
     */
    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'admin.module.comments');
    }

    /**
     * Регистрация переводов.
     *
     * @return void
     */
    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'comments');
    }

    /**
     * Регистрация событий.
     *
     * @return void
     */
    protected function registerEvents(): void
    {
        Event::listen('InetStudio\ACL\Activations\Contracts\Events\Front\ActivatedEventContract', AttachUserToCommentsListener::class);
        Event::listen('InetStudio\ACL\Users\Contracts\Events\Front\SocialRegisteredEventContract', AttachUserToCommentsListener::class);
        Event::listen(ModifyCommentEvent::class, ClearCommentsCacheListener::class);
    }

    /**
     * Регистрация наблюдателей.
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
        view()->composer('admin.module.comments::back.includes.*', function ($view) {
            $view->with('unreadBadge', CommentModel::unread()->count());
        });

        view()->composer('admin.module.comments::back.partials.analytics.users.statistic', function ($view) {
            $comments = CommentModel::select(['is_active', DB::raw('count(*) as total')])->groupBy('is_active')->get();

            $view->with('comments', $comments);
        });
    }

    /**
     * Регистрация привязок, алиасов и сторонних провайдеров сервисов.
     *
     * @return void
     */
    public function registerBindings(): void
    {
        $this->app->bind('CommentsService', CommentsService::class);
    }
}

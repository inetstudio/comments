<?php

namespace InetStudio\CommentsPackage\Comments\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class ServiceProvider.
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Загрузка сервиса.
     */
    public function boot(): void
    {
        $this->registerConsoleCommands();
        $this->registerPublishes();
        $this->registerRoutes();
        $this->registerViews();
        $this->registerTranslations();
        $this->registerEvents();
    }

    /**
     * Регистрация команд.
     */
    protected function registerConsoleCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            'InetStudio\CommentsPackage\Comments\Console\Commands\SetupCommand',
        ]);
    }

    /**
     * Регистрация ресурсов.
     */
    protected function registerPublishes(): void
    {
        $this->publishes([
            __DIR__.'/../../config/comments.php' => config_path('comments.php'),
        ], 'config');

        if (! $this->app->runningInConsole()) {
            return;
        }

        if (Schema::hasTable('comments')) {
            return;
        }

        $timestamp = date('Y_m_d_His', time());
        $this->publishes(
            [
                __DIR__.'/../../database/migrations/create_comments_tables.php.stub'
                    => database_path('migrations/'.$timestamp.'_create_comments_tables.php'),
            ],
            'migrations'
        );
    }

    /**
     * Регистрация путей.
     */
    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
    }

    /**
     * Регистрация представлений.
     */
    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'admin.module.comments');
    }

    /**
     * Регистрация переводов.
     */
    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'comments');
    }

    /**
     * Регистрация событий.
     */
    protected function registerEvents(): void
    {
        Event::listen('InetStudio\ACL\Activations\Contracts\Events\Front\ActivatedEventContract',
            'InetStudio\CommentsPackage\Comments\Contracts\Listeners\Front\AttachUserToCommentsListenerContract');
        Event::listen('InetStudio\ACL\Users\Contracts\Events\Front\SocialRegisteredEventContract',
            'InetStudio\CommentsPackage\Comments\Contracts\Listeners\Front\AttachUserToCommentsListenerContract');
    }
}

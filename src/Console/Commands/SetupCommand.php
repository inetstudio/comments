<?php

namespace InetStudio\Comments\Console\Commands;

use InetStudio\AdminPanel\Console\Commands\BaseSetupCommand;

/**
 * Class SetupCommand.
 */
class SetupCommand extends BaseSetupCommand
{
    /**
     * Имя команды.
     *
     * @var string
     */
    protected $name = 'inetstudio:comments:setup';

    /**
     * Описание команды.
     *
     * @var string
     */
    protected $description = 'Setup comments package';

    /**
     * Инициализация команд.
     *
     * @return void
     */
    protected function initCommands(): void
    {
        $this->calls = [
            [
                'type' => 'artisan',
                'description' => 'Publish migrations',
                'command' => 'vendor:publish',
                'params' => [
                    '--provider' => 'InetStudio\Comments\Providers\CommentsServiceProvider',
                    '--tag' => 'migrations',
                ],
            ],
            (! class_exists('CreateNotificationsTable')) ? [
                'type' => 'artisan',
                'description' => 'Notifications migrations',
                'command' => 'notifications:table',
            ] : [],
            (! class_exists('CreateJobsTable')) ? [
                'type' => 'artisan',
                'description' => 'Jobs migrations',
                'command' => 'queue:table',
            ] : [],
            (! class_exists('CreateFailedJobsTable')) ? [
                'type' => 'artisan',
                'description' => 'Failed jobs migrations',
                'command' => 'queue:failed-table',
            ] : [],
            [
                'type' => 'artisan',
                'description' => 'Migration',
                'command' => 'migrate',
            ],
            [
                'type' => 'artisan',
                'description' => 'Publish config',
                'command' => 'vendor:publish',
                'params' => [
                    '--provider' => 'InetStudio\Comments\Providers\CommentsServiceProvider',
                    '--tag' => 'config',
                ],
            ],
        ];
    }
}

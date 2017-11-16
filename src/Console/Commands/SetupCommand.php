<?php

namespace InetStudio\Comments\Console\Commands;

use Illuminate\Console\Command;

class SetupCommand extends Command
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
     * Список дополнительных команд.
     *
     * @var array
     */
    protected $calls = [];

    /**
     * Запуск команды.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->initCommands();

        foreach ($this->calls as $info) {
            if (! isset($info['command'])) {
                continue;
            }

            $this->line(PHP_EOL.$info['description']);
            $this->call($info['command'], $info['params']);
        }
    }

    /**
     * Инициализация команд.
     *
     * @return void
     */
    private function initCommands(): void
    {
        $this->calls = [
            [
                'description' => 'Publish migrations',
                'command' => 'vendor:publish',
                'params' => [
                    '--provider' => 'InetStudio\Comments\Providers\CommentsServiceProvider',
                    '--tag' => 'migrations',
                ],
            ],
            (! class_exists('CreateNotificationsTable')) ? [
                'description' => 'Notifications migrations',
                'command' => 'notifications:table',
                'params' => [],
            ] : [],
            (! class_exists('CreateJobsTable')) ? [
                'description' => 'Jobs migrations',
                'command' => 'queue:table',
                'params' => [],
            ] : [],
            (! class_exists('CreateFailedJobsTable')) ? [
                'description' => 'Failed jobs migrations',
                'command' => 'queue:failed-table',
                'params' => [],
            ] : [],
            [
                'description' => 'Migration',
                'command' => 'migrate',
                'params' => [],
            ],
            [
                'description' => 'Publish public',
                'command' => 'vendor:publish',
                'params' => [
                    '--provider' => 'InetStudio\Comments\Providers\CommentsServiceProvider',
                    '--tag' => 'public',
                    '--force' => true,
                ],
            ],
            [
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

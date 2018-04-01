<?php

namespace InetStudio\Comments\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

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

            $params = (isset($info['params'])) ? $info['params'] : [];

            $this->line(PHP_EOL.$info['description']);

            switch ($info['type']) {
                case 'artisan':
                    $this->call($info['command'], $params);
                    break;
                case 'cli':
                    $process = new Process($info['command']);
                    $process->run();
                    break;
            }
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
            [
                'type' => 'cli',
                'description' => 'Composer dump',
                'command' => 'composer dump-autoload',
            ],
        ];
    }
}

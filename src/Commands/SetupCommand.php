<?php

namespace InetStudio\Comments\Commands;

use Illuminate\Console\Command;

class SetupCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'inetstudio:comments:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup comments package';

    /**
     * Commands to call with their description.
     *
     * @var array
     */
    protected $calls = [];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
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
    private function initCommands()
    {
        $this->calls = [
            [
                'description' => 'Publish migrations',
                'command' => 'vendor:publish',
                'params' => [
                    '--provider' => 'InetStudio\Comments\CommentsServiceProvider',
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
                    '--provider' => 'InetStudio\Comments\CommentsServiceProvider',
                    '--tag' => 'public',
                    '--force' => true,
                ],
            ],
            [
                'description' => 'Publish config',
                'command' => 'vendor:publish',
                'params' => [
                    '--provider' => 'InetStudio\Comments\CommentsServiceProvider',
                    '--tag' => 'config',
                ],
            ],
        ];
    }
}

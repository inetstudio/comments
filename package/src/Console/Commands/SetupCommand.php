<?php

namespace InetStudio\CommentsPackage\Console\Commands;

use InetStudio\AdminPanel\Base\Console\Commands\BaseSetupCommand;

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
    protected $name = 'inetstudio:comments-package:setup';

    /**
     * Описание команды.
     *
     * @var string
     */
    protected $description = 'Setup comments package';

    /**
     * Инициализация команд.
     */
    protected function initCommands(): void
    {
        $this->calls = [
            [
                'type' => 'artisan',
                'description' => 'Comments setup',
                'command' => 'inetstudio:comments-package:comments:setup',
            ],
        ];
    }
}

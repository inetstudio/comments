<?php

return [
    /*
     * Настройки писем
     */

    'mails_admins' => [
        'send' => false,
        'to' => [],
        'subject' => 'Новый комментарий',
        'headers' => [],
    ],

    'mails_users' => [
        'send' => false,
        'subject' => 'Ответ на комментарий',
        'headers' => [],
    ],

    'queue' => [
        'enable' => false,
        'name' => 'comments_notify'
    ],

    'commentable' => [
        'article' => 'InetStudio\Articles\Contracts\Models\ArticleModelContract',
    ],
];

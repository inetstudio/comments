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
        'name' => 'comments_notify',
    ],

    'commentable' => [
        'article' => 'InetStudio\Articles\Contracts\Models\ArticleModelContract',
    ],

    'images' => [
        'quality' => 100,
        'conversions' => [
            'comment' => [
                'files' => [
                    'default' => [
                        [
                            'name' => 'comment_admin_index',
                            'fit' => [
                                'width' => 140,
                                'height' => 140,
                            ],
                        ],
                        [
                            'name' => 'comment_front',
                            'fit' => [
                                'width' => 160,
                                'height' => 160,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];

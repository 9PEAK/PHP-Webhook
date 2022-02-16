<?php

return [
    'webhook' => [
        'key'=> 'as-sk-token-sign',
        'typ'=> 'github',
        'cmd'=> [
            'cd /www/wwwroot/abc.com',
            'git pull',
            'php -c /www/server/php/composer-php73.ini /usr/bin/composer install',
            'php artisan migrate',
        ]
    ],
];

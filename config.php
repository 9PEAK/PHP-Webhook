<?php

return [

    'webhook' => [
        'key'=> 'b94dcbde1f92840619ebfae7e60dfe18',
        'typ'=> 'github',
        'msg' => '# GIT DEPLOY',
        'cmd'=> [
            'cd /www/wwwroot/webhook.9peak.net/PHP-Webhook',
            'git pull',
        ]
    ],

    'sd-erp' => [
        'key'=> 'b14ff793d03e839153e5aab734d60a66',
        'typ'=> 'gitee',
        'msg' => '# GIT DEPLOY',
        'cmd'=> [
            'cd /www/wwwroot/sd-dev.9peak.net',
            'git pull',
            'php -c /www/server/php/composer-php.ini /usr/bin/composer install',
            'php artisan migrate',
        ]
    ],

];

<?php

return [
    'webhook' => [
        'key'=> 'as-sk-token-sign',
        'typ'=> 'github',
        'msg' => '# GIT DEPLOY',
        'dir'=> '/linux/www/yun.abc.net/',
        'cmd'=> [
            'git pull'
        ]
    ],
];

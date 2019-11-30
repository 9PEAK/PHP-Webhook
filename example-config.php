<?php

return [
    'webhook' => [
        'key'=> 'as-sk-token-sign',
        'typ'=> 'github',
        'msg' => '# GIT DEPLOY',
        'dir'=> '/linux/www/9peak.net/',
        'cmd'=> [
            'git pull'
        ]
    ],
];

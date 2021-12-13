<?php

use Env\Env;

return [

    'system' => [

        'host_os' => Env::get('HOST_OS'),

        'host_path' => Env::get('HOST_PATH'),

        'guest_path' => Env::get('GUEST_PATH'),
    ],

    'error_log' => [

        'file' => 'logs/plugin.log',

        'channel' => 'errorlog',
    ],

    'var_dump' => [

        'theme' => Env::get('VAR_DUMP_THEME') ?? 'dark',

        'server_host' => Env::get('VAR_DUMP_SERVER_HOST') ?? 'tcp://127.0.0.1:9912',
    ],

    'file_link' => [

        'editor' => Env::get('DEBUG_EDITOR') ?? 'phpstorm',

        'formats' => [

            'atom' => 'atom://core/open/file?filename=%f&line=%l',

            'emacs' => 'emacs://open?url=file://%f&line=%l',

            'macvim' => 'mvim://open?url=file://%f&line=%l',

            'phpstorm' => 'phpstorm://open?file=%f&line=%l',

            'sublime' => 'subl://open?url=file://%f&line=%l',

            'textmate' => 'txmt://open?url=file://%f&line=%l',

            'vscode' => 'vscode://file/%f:%l',
        ],
    ],
];

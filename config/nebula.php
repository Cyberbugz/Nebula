<?php

return [
    'modules' => [
        'defaults' => [
            'path' => 'Modules',
        ],
        'paths' => [
            'Modules',
        ],
    ],
    'logging' => [
        'channels' => [
            'info' => 'daily',
            'debug' => 'daily',
            'warning' => 'daily',
            'error' => 'errors',
            'emergency' => 'daily',
            'critical' => 'daily',
        ],
    ],
];

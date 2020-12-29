<?php

return [
    'config' => [
        'logger' => [
            'file' => __DIR__ . '/../../var/log/' . PHP_SAPI . '/test.log',
            'stderr' => false,
        ],
    ],
];

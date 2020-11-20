<?php
/**
 * @author Maxim Kremnev <m.kremnev@netlinux.ru>
 * @return Array $configs
 */

declare(strict_types=1);


return [
    'config' => [
        'debug' => (bool)\getenv('APP_DEBUG'),
    ],
];

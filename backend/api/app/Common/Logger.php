<?php
namespace App\Common;

trait Logger
{
    private static $log_dir = 'log';

    protected function log($content) {
        if (!file_exists(self::$log_dir)) {
            mkdir(self::$log_dir);
        }
        $current_log = self::$log_dir . '/' . date('Y-m-d') . '.log';
        $log_date = date('Y-m-d H:i:s');
        file_put_contents($current_log, "[$log_date]\n" . $content . "\n", FILE_APPEND);
    }
}

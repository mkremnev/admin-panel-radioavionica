<?php
namespace App;

class Config
{

    public $slim_settings;

    public function __construct()
    {
        define('DEVELOP_MODE', false);

        mb_internal_encoding("UTF-8");
        error_reporting(E_ALL);

        $ini_config = [
            'log_errors' => true,
            'error_log' => 'log'.DIRECTORY_SEPARATOR.'error.log',
            'display_errors' => (int) DEVELOP_MODE,
            'display_startup_errors' => DEVELOP_MODE
        ];

        foreach ($ini_config as $key => $value) {
            ini_set($key, $value);
        }

        $this->slim_settings = [
            'settings' => [
                'mode' => 'production',
                'debug' => true,
                'displayErrorDetails' => true
            ]
        ];
    }

    public function get_session_resolver() {
        $session_manager = new \App\Security\SessionManager;
        return function() use ($session_manager) {
            return $session_manager;
        };
    }

    public function get_error_handler() {
        return function() {
            return new \App\ErrorHandlers\ErrorHandler;
        };
    }

    public function get_not_found_handler() {
        return function() {
            return new \App\ErrorHandlers\NotFoundHandler;
        };
    }

}

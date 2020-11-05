<?php
namespace App\Controllers;

class ControllerRegistry
{
    private static $active_controllers = [
        'Test'
    ];

    public static function register_routes(\Slim\App $app) {
        \App\Controllers\Controller::$app = $app;
        foreach (self::$active_controllers as $controller_name) {
            require_once $controller_name . '.php';
        }
        $all_classes = get_declared_classes();
        foreach ($all_classes as $class_name) {
            if (get_parent_class($class_name) == Controller::class) {
                new $class_name();
            }
        }
    }
}

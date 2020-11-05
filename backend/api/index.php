<?php
require_once __DIR__.'.\vendor'.DIRECTORY_SEPARATOR.'autoload.php';
header('Access-Control-Allow-Origin:*');


$app_config = new \App\Config;
$app = new \Slim\App($app_config->slim_settings);

$container = $app->getContainer();
$container['session'] = $app_config->get_session_resolver();
$container['errorHandler'] = $app_config->get_error_handler();
$container['notFoundHandler'] = $app_config->get_not_found_handler();

\App\Controllers\ControllerRegistry::register_routes($app);

$app->run();

<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

abstract class Controller
{
    use \App\Common\Logger;
    public static $app;
    protected $class_name;

    protected function __construct() {
        $this->class_name = get_class($this);
        $this->session = self::$app->getContainer()['session'];
    }

    protected function get_request_object(Request $request, $assoc=false) {
        $request_object = json_decode($request->getBody(), $assoc);
        $request_object->_meta = new \stdClass;
        $request_object->_meta->local_timezone_offset = (int) $request->getHeaderLine('Local-Timezone-Offset');
        return $request_object;
    }


}

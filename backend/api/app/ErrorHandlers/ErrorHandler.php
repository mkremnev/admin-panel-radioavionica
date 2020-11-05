<?php
namespace App\ErrorHandlers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ErrorHandler
{

    public function __invoke(Request $request, Response $response, \Exception $exception) {
        $status = $exception->getCode();
        $status = $status < 400 ? 500 : $status;
        $message = $exception->getMessage();
        $trace = DEVELOP_MODE ? $exception->getTraceAsString() : null;
        $data = [
            'message' => $message,
            'trace' => $trace
        ];
        return $response->json_encode($data, $status);
    }

}

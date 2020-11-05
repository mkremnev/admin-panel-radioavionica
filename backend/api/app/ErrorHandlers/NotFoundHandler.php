<?php
namespace App\ErrorHandlers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class NotFoundHandler
{

    public function __invoke(Request $request, Response $response) {
        $data = [
        'message' => 'Unknown route',
            'trace' => null
        ];
        return $response->withJson($data, 404);
    }

}

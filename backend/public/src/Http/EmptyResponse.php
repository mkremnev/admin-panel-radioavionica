<?php

declare(strict_types=1);

namespace App\Http;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\StreamInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Response;

class EmptyResponse extends Response
{
    public function __construct(int $status = 204)
    {
        parent::__construct(
            $status,
            null,
            (new StreamFactory())->createStreamFromResource(fopen('php://temp', 'rb'))
        );
    }
}

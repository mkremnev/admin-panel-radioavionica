<?php

declare(strict_types=1);

namespace App\Http\Action\v1\Military\GetUnits;

use App\Http\JsonResponse;
use App\Military\Query\AllUnits\Command;
use App\Military\Query\AllUnits\Handler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetAllUnits implements RequestHandlerInterface
{
    private Handler $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $command = new Command();
        $units = $this->handler->handle($command);

        return new JsonResponse($units);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Action\v1\Military\GetDefects;

use App\Military\Query\AllDefects\Command;
use App\Military\Query\AllDefects\Handler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Http\JsonResponse;

class GetAllDefects implements RequestHandlerInterface
{
    private Handler $handler;

    /**
     * GetAllDefects constructor.
     * @param Handler $handler
     */
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
        $defects = $this->handler->handle($command);

        return new JsonResponse($defects);
    }
}

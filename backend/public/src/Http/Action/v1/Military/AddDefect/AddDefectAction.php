<?php

declare(strict_types=1);

namespace App\Http\Action\v1\Military\AddDefect;

use App\Http\EmptyResponse;
use App\Http\Validator\Validator;
use App\Military\Command\AddDefect\Handler;
use App\Military\Command\AddDefect\Command;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AddDefectAction implements RequestHandlerInterface
{
    private Handler $handler;
    private Validator $validator;

    /**
     * AddDefectAction constructor.
     * @param Handler $handler
     * @param Validator $validator
     */
    public function __construct(Handler $handler, Validator $validator)
    {
        $this->handler = $handler;
        $this->validator = $validator;
    }

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();
        $command = new Command();

        foreach ($data as $keys => $item) {
            $command->$keys = $data[$keys] ?? '';
        }

        $this->validator->validate($command);

        $this->handler->handle($command);

        return new EmptyResponse(200);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Action\v1\Auth\Change\Email;

use App\Auth\Command\ChangeEmail\Request\Handler;
use App\Auth\Command\ChangeEmail\Request\Command;
use App\Http\EmptyResponse;
use App\Http\Validator\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RequestAction implements RequestHandlerInterface
{
    private Validator $validator;
    private Handler $handler;

    /**
     * RequestAction constructor.
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
        /** @psalm-var array{id:?string, email:?string} $data */
        $data = $request->getParsedBody();

        $command = new Command();
        $command->id = $data['id'] ?? '';
        $command->email = $data['email'] ?? '';

        $this->validator->validate($command);

        $this->handler->handle($command);
        return new EmptyResponse(201);
    }
}

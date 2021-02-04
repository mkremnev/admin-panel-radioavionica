<?php

declare(strict_types=1);

namespace App\Http\Action\v1\Auth\Reset\Password;

use App\Auth\Command\ResetPassword\Request\Command;
use App\Auth\Command\ResetPassword\Request\Handler;
use App\Http\EmptyResponse;
use App\Http\Validator\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RequestAction implements RequestHandlerInterface
{
    private Handler $handler;
    private Validator $validator;

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
        $data = $request->getParsedBody();

        $command = new Command();
        $command->email = $data['email'] ?? '';

        $this->validator->validate($command);

        $this->handler->handle($command);

        return new EmptyResponse(201);
    }
}

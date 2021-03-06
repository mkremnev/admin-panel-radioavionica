<?php

declare(strict_types=1);

namespace App\Http\Action\v1\Auth\SignIn;

use App\Auth\Command\SignIn\Command;
use App\Auth\Command\SignIn\Handler;
use App\Http\JsonResponse;
use App\Http\Validator\Validator;
use App\Security\SessionManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function var_dump;

class RequestAction implements RequestHandlerInterface
{
    private Validator $validator;
    private Handler $handler;
    private SessionManager $session;

    /**
     * @inheritDoc
     */
    public function __construct(Handler $handler, Validator $validator, SessionManager $session)
    {
        $this->handler = $handler;
        $this->validator = $validator;
        $this->session = $session;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $command = new Command();
        $command->email = $data['email'] ?? '';
        $command->password = $data['password'] ?? '';

        $this->validator->validate($command);

        $user = $this->handler->handle($command);

        $this->session->put('user', $user);

        return new JsonResponse($user);
    }
}

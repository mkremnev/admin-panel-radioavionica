<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\JsonResponse;
use App\Http\Validator\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Http\Validator\Validator;
use Psr\Http\Server\MiddlewareInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

class ValidationExceptionHandler implements MiddlewareInterface
{
    private Validator $validator;

    /**
     * ValidationExceptionHandler constructor.
     * @param Validator $validator
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (ValidationException $exception) {
            $errors = [];
            /** @var ConstraintViolationInterface $violation */
            foreach ($exception->getViolations() as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }
            return new JsonResponse(['errors' => $errors], 422);
        }
    }
}

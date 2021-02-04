<?php

declare(strict_types=1);

namespace App\Http\Action\v1\Military\AddUnit;

use App\Http\EmptyResponse;
use App\Http\Validator\Validator;
use App\Military\Command\AddUnit\Command;
use App\Military\Command\AddUnit\Handler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function array_key_exists;
use function json_decode;
use function json_encode;
use function print_r;

class AddUnitsAction implements RequestHandlerInterface
{
    private Handler $handler;
    private Validator $validator;

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

        $files = $request->getUploadedFiles();

        if (array_key_exists('json', $data)) {
            $data = json_decode($data['json'], true);
        }

        $command = new Command();

        foreach ($data as $keys => $item){
            $command->$keys = $data[$keys] ?? '';
        }

        if ($files) {
            $command->files = $files['procuration'];
        }

        $this->validator->validate($command);

        $this->handler->handle($command);

        return new EmptyResponse(200);
    }
}

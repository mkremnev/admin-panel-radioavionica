<?php

declare(strict_types=1);

namespace App\Http\Test\Unit\Middleware;

use App\Http\Middleware\ClearEmptyInput;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Factory\UploadedFileFactory;

use const UPLOAD_ERR_NO_FILE;
use const UPLOAD_ERR_OK;

class ClearEmptyInputTest extends TestCase
{
    public function testParsedBody(): void
    {
        $middleware = new ClearEmptyInput();

        $request = (new ServerRequestFactory())->createServerRequest('Post', 'http://test')
            ->withParsedBody([
                'null' => null,
                'space' => ' ',
                'string' => 'String ',
                'nested' => [
                    'null' => null,
                    'space' => ' ',
                    'name' => ' Name'
                ]
            ]);
        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->expects($this->once())->method('handle')
            ->willReturnCallback(
                static function (ServerRequestInterface $request): ResponseInterface {
                    self::assertEquals([
                        'null' => null,
                        'space' => '',
                        'string' => 'String',
                        'nested' => [
                            'null' => null,
                            'space' => '',
                            'name' => 'Name'
                        ]], $request->getParsedBody());
                    return (new ResponseFactory())->createResponse();
                }
            );
        $middleware->process($request, $handler);
    }

    public function testPUploadedFiles(): void
    {
        $middleware = new ClearEmptyInput();

        $realFiles = (new UploadedFileFactory())->createUploadedFile(
            (new StreamFactory())->createStream(''),
            0,
            UPLOAD_ERR_OK
        );

        $noFiles = (new UploadedFileFactory())->createUploadedFile(
            (new StreamFactory())->createStream(''),
            0,
            UPLOAD_ERR_NO_FILE
        );

        $request = (new ServerRequestFactory())->createServerRequest('Post', 'http://test')
            ->withUploadedFiles([
                'real_file' => $realFiles,
                'none_file' => $noFiles,
                'files' => [$realFiles, $noFiles]
            ]);


        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->expects($this->once())->method('handle')
            ->willReturnCallback(
                static function (ServerRequestInterface $request) use ($realFiles): ResponseInterface {
                    self::assertEquals([
                        'real_file' => $realFiles,
                        'files' => [$realFiles]
                        ], $request->getUploadedFiles());
                    return (new ResponseFactory())->createResponse();
                }
            );
        $middleware->process($request, $handler);
    }
}

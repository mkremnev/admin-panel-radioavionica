<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use phpDocumentor\Reflection\Types\Mixed_;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;

use function is_array;
use function is_string;
use function trim;

use const UPLOAD_ERR_NO_FILE;

class ClearEmptyInput implements MiddlewareInterface
{

    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $request = $request
            ->withParsedBody(self::filterString($request->getParsedBody()))
            ->withUploadedFiles(self::filterFiles($request->getUploadedFiles()));

        return $handler->handle($request);
    }

    /**
     * @param null|array|object $items
     * @return null|array|object
     */
    private static function filterString($items)
    {
        if (!is_array($items)) {
            return $items;
        }

        $result = [];

        /**
         * @var string $key
         * @var null|array|object $item
         */
        foreach ($items as $key => $item) {
            if (is_string($item)) {
                $result[$key] = trim($item);
            } else {
                $result[$key] = self::filterString($item);
            }
        }
        return $result;
    }

    private static function filterFiles(array $items): array
    {
        $result = [];

        /**
         * @var string $key
         * @var array|UploadedFileInterface $item
         */
        foreach ($items as $key => $item) {
            if ($item instanceof UploadedFileInterface) {
                if ($item->getError() !== UPLOAD_ERR_NO_FILE) {
                    $result[$key] = $item;
                }
            } else {
                $result[$key] = self::filterFiles($item);
            }
        }
        return $result;
    }
}

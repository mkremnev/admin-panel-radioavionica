<?php

declare(strict_types=1);

namespace Test\Unit\Http;

use App\Http\JsonResponse;
use PHPUnit\Framework\TestCase;
use stdClass;

class JsonResponseTest extends TestCase
{
    public function testIntWithCode(): void
    {
        $response = new JsonResponse(12, 201);

        self::assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        self::assertEquals('12', $response->getBody()->getContents());
        self::assertEquals(201, $response->getStatusCode());
    }

    /**
     * @dataProvider getCases
     * @param mixed $source
     * @param mixed $expected
     */
    public function testResponse($source, $expected): void
    {
        $response = new JsonResponse($source);
        self::assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        self::assertEquals($expected, $response->getBody()->getContents());
        self::assertEquals(200, $response->getStatusCode());
    }

    /** @return array<mixed> */
    public function getCases(): array
    {
        $object = new stdClass();
        $object->str = 'value';
        $object->int = 1;
        $object->none = null;

        $array = ['str' => 'value', 'int' => 1, "none" => null];

        return [
            'null' => [null, "null"],
            'empty' => ['', '""'],
            'number' => [12, '12'],
            'object' => [$object, '{"str":"value","int":1,"none":null}'],
            'array' => [$array, '{"str":"value","int":1,"none":null}']
        ];
    }
}

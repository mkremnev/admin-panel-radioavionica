<?php

namespace App\Frontend;

use function http_build_query;

class FrontendUrlGenerator
{
    private string $baseUrl;

    /**
     * FrontendUrlGenerator constructor.
     * @param string $baseUrl
     */
    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $uri
     * @param array $params
     * @return string
     */
    public function generate(string $uri, array $params = []): string
    {
        return $this->baseUrl . ($uri ? '/' . $uri : '') . ($params ? '?' . http_build_query($params) : '');
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
}

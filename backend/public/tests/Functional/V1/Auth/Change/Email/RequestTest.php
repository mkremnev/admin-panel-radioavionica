<?php

declare(strict_types=1);

namespace Test\Functional\V1\Auth\Change\Email;

use Ramsey\Uuid\Uuid;
use Test\Functional\Json;
use Test\Functional\WebTestCase;

class RequestTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([
            RequestFixtures::class
        ]);
    }

    public function testMethod(): void
    {
        $response = $this->app()->handle(self::json('GET', '/v1/change/email'));

        self::assertEquals(405, $response->getStatusCode());
    }

    public function testSuccess(): void
    {
        $this->mailer()->clear();

        $response = $this->app()->handle(self::json('POST', '/v1/change/email', [
            'id' => RequestFixtures::VALID,
            'email' => 'new-email@app.test'
        ]));

        self::assertTrue($this->mailer()->hasEmailSentTo('new-email@app.test'));

        self::assertEquals(201, $response->getStatusCode());
    }

    public function testNotValidIdEn(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/change/email', [
            'id' => Uuid::uuid4()->toString(),
            'email' => 'new-email@app.test'
        ])->withHeader('Accept-Language', 'en'));

        self::assertEquals(409, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            'message' => 'User is not found.'
        ], Json::decode($body));
    }

    public function testNotValidIdRu(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/change/email', [
            'id' => Uuid::uuid4()->toString(),
            'email' => 'new-email@app.test'
        ])->withHeader('Accept-Language', 'ru'));

        self::assertEquals(409, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            'message' => 'Пользователь не найден.'
        ], Json::decode($body));
    }

    public function testEmailExistEn(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/change/email', [
            'id' => RequestFixtures::VALID,
            'email' => 'old-email@app.test'
        ])->withHeader('Accept-Language', 'en'));

        self::assertEquals(409, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            'message' => 'Email is already same.'
        ], Json::decode($body));
    }

    public function testEmailExistRu(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/change/email', [
            'id' => RequestFixtures::VALID,
            'email' => 'old-email@app.test'
        ])->withHeader('Accept-Language', 'ru'));

        self::assertEquals(409, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            'message' => 'Email совпадает с текущим.'
        ], Json::decode($body));
    }

    public function testEmptyRu(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/change/email', [])
            ->withHeader('Accept-Language', 'ru'));

        self::assertEquals(422, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            "errors" => [
                "id" => "Значение не должно быть пустым.",
                "email" => "Значение не должно быть пустым."
            ]
        ], Json::decode($body));
    }

    public function testEmptyEn(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/change/email', [])
            ->withHeader('Accept-Language', 'en'));

        self::assertEquals(422, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            "errors" => [
                "id" => "This value should not be blank.",
                "email" => "This value should not be blank."
            ]
        ], Json::decode($body));
    }

    public function testNotValidEmailRu(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/change/email', [
            'id' => RequestFixtures::VALID,
            'email' => 'old-email'
        ])
            ->withHeader('Accept-Language', 'ru'));

        self::assertEquals(422, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            "errors" => [
                "email" => "Значение адреса электронной почты недопустимо."
            ]
        ], Json::decode($body));
    }

    public function testNotValidEmailEn(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/change/email', [
            'id' => RequestFixtures::VALID,
            'email' => 'old-email'
        ])
            ->withHeader('Accept-Language', 'en'));

        self::assertEquals(422, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            "errors" => [
                "email" => "This value is not a valid email address."
            ]
        ], Json::decode($body));
    }

    public function testNonActiveEn(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/change/email', [
            'id' => RequestFixtures::NONACTIVE,
            'email' => 'new-non-active@app.test'
        ])
            ->withHeader('Accept-Language', 'en'));

        self::assertEquals(409, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
                'message' => 'User is not active.'
        ], Json::decode($body));
    }

    public function testNonActiveRu(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/change/email', [
            'id' => RequestFixtures::NONACTIVE,
            'email' => 'new-non-active@app.test'
        ])
            ->withHeader('Accept-Language', 'ru'));

        self::assertEquals(409, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            'message' => 'Пользователь не активен.'
        ], Json::decode($body));
    }
}

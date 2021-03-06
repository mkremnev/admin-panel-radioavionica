<?php

declare(strict_types=1);

namespace App\Auth\Test\Unit\Service;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Token;
use App\Auth\Service\JoinConfirmationSender;
use App\Frontend\FrontendUrlGenerator;
use App\Frontend\FrontendUrlTwigExtension;
use DateTimeImmutable;
use RuntimeException;
use Ramsey\Uuid\Uuid;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;

class JoinConfirmSenderTest extends \PHPUnit\Framework\TestCase
{
    public function testSuccess(): void
    {
        $to = new Email('user@test.test');
        $token = new Token(Uuid::uuid4()->toString(), new DateTimeImmutable());
        $frontendUrl = 'http://test';
        $confirmUrl = $frontendUrl .  '/join/confirm?token=' . $token->getValue();

        $twig = $this->createMock(Environment::class);
        $twig->expects(self::once())->method('render')->with(
            self::equalTo('auth/join/confirm.html.twig'),
            self::equalTo(['token' => $token]),
        )->willReturn($body = '<a href="' . $confirmUrl . '">' . $confirmUrl . '</a>');

        $mailer = $this->createMock(Swift_Mailer::class);
        $mailer->expects(self::once())->method('send')
            ->willReturnCallback(static function (Swift_Message $message) use ($to, $body): int {
                self::assertEquals([$to->getValue() => null], $message->getTo());
                self::assertEquals('Join confirmation', $message->getSubject());
                self::assertEquals($body, $message->getBody());
                self::assertEquals('text/html', $message->getBodyContentType());
                return 1;
            });

        $sender = new JoinConfirmationSender($mailer, $twig);

        $sender->send($to, $token);
    }

    public function testError(): void
    {
        $to = new Email('user@test.test');
        $token = new Token(Uuid::uuid4()->toString(), new DateTimeImmutable());
        $frontendUrl = 'http://test';
        $confirmUrl = $frontendUrl .  '/join/confirm?token=' . $token->getValue();

        $twig = $this->createStub(Environment::class);
        $twig->method('render')->willReturn('<a href="' . $confirmUrl . '">' . $confirmUrl . '</a>');

        $mailer = $this->createStub(Swift_Mailer::class);
        $mailer->method('send')->willReturn(0);

        $sender = new JoinConfirmationSender($mailer, $twig);
        $this->expectException(RuntimeException::class);

        $sender->send($to, $token);
    }
}

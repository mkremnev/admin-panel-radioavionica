<?php

declare(strict_types=1);

namespace App\Auth\Fixtures;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\Token;
use App\Auth\Entity\User\User;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Ramsey\Uuid\Uuid;

class UserFixture extends AbstractFixture
{
    private const PASS_HASH = 'e5e9fa1ba31ecd1ae84f75cabana474f3a663f05f4';

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $user = new User(
            new Id('00000000-0000-0000-0000-000000000001'),
            $date = new DateTimeImmutable('-30 day'),
            new Email('user@app.test'),
            self::PASS_HASH,
            new Token($value = Uuid::uuid4()->toString(), $date->modify('+1 day'))
        );

        $user->confirmJoin($value, $date);

        $manager->persist($user);

        $manager->flush();
    }
}

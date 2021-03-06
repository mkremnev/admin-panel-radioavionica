<?php

declare(strict_types=1);

namespace Test\Functional\V1\Auth\Change\Email;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\Token;
use App\Auth\Entity\User\User;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Ramsey\Uuid\Uuid;

class RequestFixtures extends AbstractFixture
{
    public const VALID = "00000000-0000-0000-0000-000000000001";
    public const NONACTIVE = "00000000-0000-0000-0000-000000000002";

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $user = User::requestJoinByEmail(
            new Id(self::VALID),
            $date = new DateTimeImmutable('-10 day'),
            new Email('old-email@app.test'),
            'password-hash',
            new Token($value = Uuid::uuid4()->toString(), $date->modify('+1 day'))
        );

        $user->confirmJoin($value, $date);

        $manager->persist($user);

        $manager->flush();

        $user = User::requestJoinByEmail(
            new Id(self::NONACTIVE),
            $date = new DateTimeImmutable('-10 day'),
            new Email('non-active@app.test'),
            'password-hash',
            new Token($value = Uuid::uuid4()->toString(), $date->modify('+1 day'))
        );

        $manager->persist($user);

        $manager->flush();
    }
}

<?php

declare(strict_types=1);

namespace App\Military\Fixtures;

use App\Military\Entity\Units\Address;
use App\Military\Entity\Units\Commander;
use App\Military\Entity\Units\Id;
use App\Military\Entity\Units\Name;
use App\Military\Entity\Units\Official;
use App\Military\Entity\Units\Unit;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;

class UnitFixtures extends AbstractFixture
{
    /**
     * @inheritDoc
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('ru_RU');
        for ($i = 0; $i < 5; $i++) {
            $unit = new Unit(
                Id::generate(),
                new Name($faker->randomElement(['31232', '65213', '32342', '12312'])),
                new Address($faker->address),
                new Commander($faker->lastName, $faker->firstNameMale, $faker->firstName),
                '20'
            );

            $unit->attachOfficials(
                new Official(
                    $faker->company,
                    $faker->randomElement(['Полковник', 'Подполковник', 'Майор', 'Капитан']),
                    $faker->name,
                    $faker->phoneNumber
                )
            );

            $unit->attachOfficials(
                new Official(
                    $faker->company,
                    $faker->randomElement(['Полковник', 'Подполковник', 'Майор', 'Капитан']),
                    $faker->name,
                    $faker->phoneNumber
                )
            );

            $manager->persist($unit);
        }

        $manager->flush();
    }
}

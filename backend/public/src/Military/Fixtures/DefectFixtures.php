<?php

declare(strict_types=1);

namespace App\Military\Fixtures;

use App\Military\Entity\Defect\Components;
use App\Military\Entity\Defect\Defect;
use App\Military\Entity\Defect\District;
use App\Military\Entity\Defect\Fault;
use App\Military\Entity\Defect\Id;
use App\Military\Entity\Defect\Note;
use App\Military\Entity\Defect\Unit;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;

class DefectFixtures extends AbstractFixture
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
            $defect = new Defect(
                Id::generate(),
                new Unit($faker->randomElement(['31232', '65213', '32342', '12312'])),
                $faker->lastName . ' ' . $faker->firstName,
                new District((string)$faker->randomElement(['ЮВО', 'ВВО', 'ЦВО', 'Северный флот', 'ЗВО'])),
                (string)$faker->randomDigitNotNull,
                (string)$faker->year,
                (string)$faker->date('d.m.Y'),
                (string)$faker->randomDigitNotNull,
                (string)$faker->randomDigitNotNull,
                new Fault((string)$faker->randomDigitNotNull, (string)$faker->randomDigitNotNull),
                new Components(
                    (string)$faker->randomDigitNotNull,
                    (string)$faker->randomDigitNotNull,
                    (string)$faker->randomDigitNotNull,
                    (string)$faker->randomDigitNotNull,
                    (string)$faker->randomDigitNotNull,
                    (string)$faker->randomDigitNotNull,
                    (string)$faker->randomDigitNotNull,
                    (string)$faker->randomDigitNotNull,
                    (string)$faker->randomDigitNotNull,
                    (string)$faker->randomDigitNotNull,
                    (string)$faker->randomDigitNotNull,
                    (string)$faker->randomDigitNotNull,
                    (string)$faker->randomDigitNotNull,
                    (string)$faker->randomDigitNotNull,
                    (string)$faker->randomDigitNotNull,
                    (string)$faker->randomDigitNotNull,
                    (string)$faker->randomDigitNotNull,
                    (string)$faker->randomDigitNotNull,
                    (string)$faker->randomDigitNotNull
                )
            );

            $defect->attachNotes(new Note(
                $faker->text(40)
            ));

            $defect->attachNotes(new Note(
                $faker->text(40)
            ));

            $manager->persist($defect);
        }

        $manager->flush();
    }
}

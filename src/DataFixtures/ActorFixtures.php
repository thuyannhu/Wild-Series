<?php

namespace App\DataFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use App\Entity\Actor;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        'The Walking Dead',
        'Breaking Bad',
        'Better Call Saul',
        'Love, Death and Robots',
        'Sense8',
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $actor = new Actor();
            $actor->setName($faker->name());

            $randomPrograms = array_rand(self::PROGRAMS, 3);
            foreach ($randomPrograms as $programIndex) {
                $programName = self::PROGRAMS[$programIndex];
                $actor->addProgram($this->getReference('program_' . $programName));
            }

            $manager->persist($actor);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProgramFixtures::class,
        ];
    }
}

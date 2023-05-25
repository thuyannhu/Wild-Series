<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        'The Walking Dead' => 'Action',
        'Breaking Bad' => 'Drama',
        'Better Call Saul' => 'Drama',
        'Love, Death and Robots' => 'Animation',
        'Sense8' => 'Sci-Fi',
    ];

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        foreach (self::PROGRAMS as $programName => $programCategory) {
            $program = new Program();

            $program->setTitle($programName);

            $program->setSynopsis($faker->paragraphs(1, true));

            $program->setCategory($this->getReference('category_' . $programCategory));

            $this->addReference('program_' . $programName, $program);
            
            $manager->persist($program);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          CategoryFixtures::class,
        ];
    }


}
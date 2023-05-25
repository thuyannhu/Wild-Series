<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

//Tout d'abord nous ajoutons la classe Factory de FakerPhp
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
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
    
            foreach (self::PROGRAMS as $key => $programName) {
                for($i = 1; $i <= 5; $i++) {
                    $season = new Season();
                    $season->setNumber($i);
                    $season->setYear($faker->year());
                    $season->setDescription($faker->paragraphs(3, true));
        
                    $season->setProgram($this->getReference('program_' . $programName));
                    $this->addReference($programName .'season_' . $i, $season);
                    $manager->persist($season);
                }
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
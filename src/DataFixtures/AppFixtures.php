<?php

namespace App\DataFixtures;

use App\Entity\CarAd;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 34; $i++) {
            $carAd = new CarAd();
            // $carAd->setUser();
            $carAd->setTitle($faker->streetName());
            $carAd->setDescription($faker->text());
            $carAd->setYear($faker->year());
            $carAd->setKilometers($faker->randomNumber(6));
            $carAd->setBrand('FORD');
            $carAd->setModel($faker->streetName());
            $carAd->setImage($faker->url());
            $manager->persist($carAd);
        }

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Stock;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        //Créer trois Stock fakés
        for($i = 0; $i<=3; $i++){
            $stock = new Stock();
            $stock->setName($faker->country)
                    ->setQuantity($faker->randomDigitNotNull );
            $manager->persist($stock);
            //creer entre 4 et 6 articles

            for($j = 1; $j <= mt_rand(4, 6); $j++){

                $article = new Article();
                $article->setName($faker->city)
                        ->setPrice($faker->randomDigit )
                        ->setDescription($faker->paragraph())
                        ->setStock($stock);
                $manager->persist($article);
            }
        }
        $manager->flush();
    }
}

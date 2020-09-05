<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\FocusLieu;
use App\Entity\FocusPays;
use App\Entity\FocusVille;
use App\Entity\MarkerLieu;
use App\Entity\MarkerPays;
use App\Entity\MarkerVille;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');

        //Je gere la creation de fausse données pour les Focus Pays
        for ($i = 0; $i <= 30; $i++) {
            $FocusPays = new FocusPays();

            $title = $faker->sentence();
            $coverImage = $faker->imageUrl(1000, 350);
            $intro = $faker->paragraph(2);

            $FocusPays->setTitle($title)
                ->setImageCover($coverImage)
                ->setIntroduction($intro);


            //Je gere la creation de Marker Pays

            $MarkerPays = new MarkerPays();

            $title = $faker->sentence();
            $longitude = $faker->longitude();
            $latitude = $faker->latitude();
            $address = $faker->country;


            $MarkerPays->setTitle($title)
                ->setLongitude($longitude)
                ->setLatitude($latitude)
                ->setFocusPays($FocusPays)
                ->setAdresse($address);

            $manager->persist($MarkerPays);

            $manager->persist($FocusPays);

            for ($j = 0; $j <= mt_rand(2, 5); $j++) {
                $FocusVille = new FocusVille();

                $title = $faker->sentence();
                $coverImage = $faker->imageUrl(1000, 350);
                $intro = $faker->paragraph(2);
                $slug = $faker->slug;
                $content =  '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';


                $FocusVille->setTitle($title)
                    ->setImageCover($coverImage)
                    ->setIntroduction($intro)
                    ->setContent($content)
                    ->setFocusPays($FocusPays)
                    ->setSlug($slug);

                //Je gere la creation de Marker Ville

                $MarkerVille = new MarkerVille();

                $title = $faker->sentence();
                $longitude = $faker->longitude();
                $latitude = $faker->latitude();
                $address = $faker->country;

                $MarkerVille->setTitle($title)
                    ->setLongitude($longitude)
                    ->setLatitude($latitude)
                    ->setFocusVille($FocusVille)
                    ->setAdresse($address);

                $manager->persist($MarkerVille);

                $manager->persist($FocusVille);
            }

            for ($j = 0; $j <= mt_rand(2, 4); $j++) {
                $FocusLieu = new FocusLieu();

                $title = $faker->sentence();
                $slug = $faker->slug;
                $content =  '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';


                $FocusLieu->setTitle($title)
                    ->setContent($content)
                    ->setFocusVille($FocusVille)
                    ->setSlug($slug);
                //Je gere la creation de Marker Ville

                $MarkerLieu = new MarkerLieu();

                $title = $faker->sentence();
                $longitude = $faker->longitude();
                $latitude = $faker->latitude();
                $address = $faker->country;
                $slug = $faker->slug;

                $MarkerLieu->setTitle($title)
                    ->setLongitude($longitude)
                    ->setLatitude($latitude)
                    ->setFocusLieu($FocusLieu)
                    ->setAdresse($address)
                    ->setSlug($slug);

                $manager->persist($MarkerLieu);

                $manager->persist($FocusLieu);
            }
        }

        $manager->flush();
    }
}

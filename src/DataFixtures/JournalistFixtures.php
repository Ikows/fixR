<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class JournalistFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-Fr');

        //Nous gérons les utilisateurs
        $users = [];
        $genres = ['male', 'female'];

        for ($i = 1; $i <= 10; $i++) {
            $user = new User();

            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99) . '.jpg';

            $hash = $this->encoder->encodePassword($user, 'password');

            $picture .= ($genre == 'male' ? 'men/' : 'women/') . $pictureId;

            $user->setPrenom($faker->firstName($genre))
                ->setNom($faker->lastName)
                ->setEmail($faker->email)
                ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>')
                ->setPassword($hash)
                ->setPhoto($picture)
                ->setCreatedAt($faker->dateTime());

            $manager->persist($user);
            $users[] = $user;
        }

        for ($i = 1; $i <=30; $i++) {
            $article = new Article();

            $title = $faker->sentence();
            $coverImage = $faker->imageURL(1000, 350);
            $content = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';
            $city = $faker->city;

            $user = $users[mt_rand(0, count($users) - 1)];

            $article->setTitle($title)
                ->setImage($coverImage)
                ->setContenu($content)
                ->setAuteur($user)
                ->setVille($city)
                ->setSupport('article')
                ->setCreatedAt($faker->dateTime());

            $manager->persist($article);

        }

        $manager->flush();
    }
}

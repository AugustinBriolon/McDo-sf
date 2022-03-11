<?php

namespace App\DataFixtures;

use App\Entity\District;
use App\Entity\Product;
use App\Entity\ProductRestaurant;
use App\Entity\Restaurant;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 20; $i++) {
            $district = new District();
            $district->setName('Paris ' . $i);
            $district->setPopulation(rand(50000, 200000));
            $district->setCreatedAt(new \DateTime());
            $district->setUpdatedAt(new \DateTime());

            $manager->persist($district);

            for ($j = 0; $j < 10; $j++) {
                $restaurant = new Restaurant();
                $restaurant->setName('McDo #' . $i * ($j + 1));
                $restaurant->setDistrict($district);
                $restaurant->setCreatedAt(new \DateTime());
                $restaurant->setUpdatedAt(new \DateTime());

                $manager->persist($restaurant);
            }
        }

        $manager->flush();

        $products = ['Frites', 'Cheeseburger', 'Big Mac', 'Royal Cheese', 'Nuggets x6',
            'Nuggets x9', 'Sunday', 'Mc Chicken', 'Mc First', 'Royal Bacon'];

        foreach ($products as $product) {
            $productEntity = new Product();
            $productEntity->setName($product);
            $productEntity->setCreatedAt(new \DateTime());
            $productEntity->setUpdatedAt(new \DateTime());

            $manager->persist($productEntity);
        }

        $manager->flush();

        $productRepo = $manager->getRepository(Product::class);
        $restaurantRepo = $manager->getRepository(Restaurant::class);

        $allProducts = $productRepo->findAll();
        $allRestaurants = $restaurantRepo->findAll();

        foreach ($allRestaurants as $restaurant) {
            foreach ($allProducts as $product) {
                $productRestaurant = new ProductRestaurant();
                $productRestaurant->setProduct($product);
                $productRestaurant->setRestaurant($restaurant);
                $productRestaurant->setStock(rand(50, 2000));
                $productRestaurant->setPrice(rand(100, 1000) / 100);

                $manager->persist($productRestaurant);
            }
        }

        for ($i = 1; $i <= 10; $i++) {
            $user = new User;
            $user->setEmail('test' . $i . '@gmail.com');
            $password = $this->hasher->hashPassword($user, 'password');
            $user->setPassword($password);
            $user->setRoles([
                'ROLE_ADMIN',
                'ROLE_USER'
            ]);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
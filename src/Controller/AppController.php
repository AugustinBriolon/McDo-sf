<?php

namespace App\Controller;

use App\Repository\DistrictRepository;
use App\Repository\ProductRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(
        RestaurantRepository $restaurantRepository
    ): Response
    {
        $restaurants = $restaurantRepository->findBy([], [
            'createdAt' => 'DESC'
        ], 20);

        return $this->render('app/index.html.twig', [
            'restaurants' => $restaurants,
        ]);
    }

    public function nav(
        DistrictRepository $districtRepository,
        ProductRepository  $productRepository
    )
    {
        $districts = $districtRepository->findBy([], [], 5);
        $products = $productRepository->findAll();

        return $this->render('partial/nav.html.twig', [
            'districts' => $districts,
            'products' => $products
        ]);
    }

}
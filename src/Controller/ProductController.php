<?php

namespace App\Controller;

use App\Repository\DistrictRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/produits', name: 'app_products')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAllWithAveragePrice();

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }
}
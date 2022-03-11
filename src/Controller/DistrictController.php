<?php

namespace App\Controller;

use App\Repository\DistrictRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DistrictController extends AbstractController
{
    #[Route('/arrondissements', name: 'app_districts')]
    public function index(DistrictRepository $districtRepository): Response
    {
        $districts = $districtRepository->findAll();

        return $this->render('district/index.html.twig', [
            'districts' => $districts
        ]);
    }
}
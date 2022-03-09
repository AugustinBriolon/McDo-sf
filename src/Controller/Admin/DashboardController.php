<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Entity\District;
use App\Entity\ProductRestaurant;
use App\Entity\Restaurant;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ProductCrudController::class)->generateUrl());

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('McDo - I\'m lovin\' it');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Core');
        yield MenuItem::linkToCrud('District', 'fas fa-building', District::class);
        yield MenuItem::linkToCrud('Restaurants', 'fas fa-utensils', Restaurant::class);
        yield MenuItem::section('Stuff');
        yield MenuItem::linkToCrud('Product', 'fas fa-hamburger', Product::class);
        yield MenuItem::section('Stocks');
        yield MenuItem::linkToCrud('ProductRestaurant', 'fas fa-random', ProductRestaurant::class);
    }
}

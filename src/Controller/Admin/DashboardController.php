<?php

namespace App\Controller\Admin;

use App\Entity\District;
use App\Entity\Product;
use App\Entity\ProductRestaurant;
use App\Entity\Restaurant;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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

    public function configureUserMenu(UserInterface|User $user): UserMenu
    {
        return parent::configureUserMenu($user)->setAvatarUrl('/uploads/user/' . $user->getPicture());
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Core');
        yield MenuItem::linkToCrud('Districts', 'fas fa-building', District::class);
        yield MenuItem::linkToCrud('Restaurants', 'fas fa-utensils', Restaurant::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
        yield MenuItem::section('Stuff');
        yield MenuItem::linkToCrud('Products', 'fas fa-hamburger', Product::class);
        yield MenuItem::section('Stocks');
        yield MenuItem::linkToCrud('Restaurants', 'fas fa-random', ProductRestaurant::class);
    }
}
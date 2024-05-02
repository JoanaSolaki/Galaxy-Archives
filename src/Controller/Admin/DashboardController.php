<?php

namespace App\Controller\Admin;

use App\Entity\Galaxy;
use App\Entity\Lifeform;
use App\Entity\Planet;
use App\Entity\ReportLifeform;
use App\Entity\ReportPlanet;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Galaxy Archives')
            ->setFaviconPath('img/stars.svg');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('User');
        yield MenuItem::linkToCrud('All users', 'fa-solid fa-user', User::class);
        yield MenuItem::linkToCrud('Add user', 'fa-solid fa-user', User::class)
            ->setAction('new');
        yield MenuItem::section('Galaxy');
        yield MenuItem::linkToCrud('All galaxies', 'fa-regular fa-star', Galaxy::class);
        yield MenuItem::linkToCrud('Add galaxy', 'fa-regular fa-star', Galaxy::class)
            ->setAction('new');

        yield MenuItem::section('Planet');
        yield MenuItem::linkToCrud('All planets', 'fa-solid fa-meteor', Planet::class);
        yield MenuItem::linkToCrud('Add planet', 'fa-solid fa-meteor', Planet::class)
            ->setAction('new');
        yield MenuItem::linkToCrud('All reports', 'fa-solid fa-meteor', ReportPlanet::class);
        yield MenuItem::linkToCrud('Add report', 'fa-solid fa-meteor', ReportPlanet::class)
            ->setAction('new');

        yield MenuItem::section('Lifeform');
        yield MenuItem::linkToCrud('All lifeforms', 'fa-solid fa-dragon', Lifeform::class);
        yield MenuItem::linkToCrud('Add lifeform', 'fa-solid fa-dragon', Lifeform::class)
            ->setAction('new');
        yield MenuItem::linkToCrud('All reports', 'fa-solid fa-dragon', ReportLifeform::class);
        yield MenuItem::linkToCrud('Add report', 'fa-solid fa-dragon', ReportLifeform::class)
            ->setAction('new');
    }
}

<?php

declare(strict_types=1);

namespace App\Web\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return $this->redirectToRoute('admin_category_index');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Www');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Website Configuration');

        yield MenuItem::linkTo(CategoryCrudController::class, 'Categories', 'fa fa-tags');
        yield MenuItem::linkTo(SeoCrudController::class, 'SEO', 'fa fa-search');

        yield MenuItem::section('Content');

        yield MenuItem::linkTo(ReviewCrudController::class, 'Reviews', 'fa fa-comments');
        yield MenuItem::linkTo(ApplicationCrudController::class, 'Applications', 'fa fa-inbox');
    }
}

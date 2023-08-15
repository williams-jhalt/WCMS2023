<?php

namespace App\Controller\Admin;

use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\ProductImage;
use App\Entity\ProductType;
use App\Entity\ProductManufacturer;
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

        return $this->redirect($adminUrlGenerator->setController(ProductCrudController::class)->generateUrl());

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('WCMS');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToUrl('Home', 'fa fa-home', $this->generateUrl('app_default')),
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Catalog'),
            MenuItem::linkToCrud('Products', 'fa fa-tags', Product::class),
            MenuItem::linkToCrud('Product Types', 'fa fa-tags', ProductType::class),
            MenuItem::linkToCrud('Manufacturers', 'fa fa-tags', ProductManufacturer::class),
            MenuItem::linkToCrud('Images', 'fa fa-tags', ProductImage::class),

            MenuItem::section('Site'),            
            MenuItem::linkToCrud('Users', 'fa fa-tags', User::class),
            MenuItem::linkToCrud('Customers', 'fa fa-tags', Customer::class),

            MenuItem::linkToRoute('Update from ERP', 'fa file-import', 'app_reload_from_erp'),
        ];
    }
}
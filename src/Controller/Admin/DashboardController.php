<?php

namespace App\Controller\Admin;

use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\ProductImage;
use App\Entity\ProductType;
use App\Entity\ProductManufacturer;
use App\Entity\User;
use App\Repository\CustomerRepository;
use App\Repository\ProductImageRepository;
use App\Repository\ProductManufacturerRepository;
use App\Repository\ProductRepository;
use App\Repository\ProductTypeRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    public function __construct(
        private ProductRepository $productRepository,
        private ProductTypeRepository $productTypeRepository,
        private ProductManufacturerRepository $productManufacturerRepository,
        private ProductImageRepository $productImageRepository,
        private CustomerRepository $customerRepository,
        private UserRepository $userRepository
    ) {}

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    { 

        $totalProducts = $this->productRepository->createQueryBuilder('o')->select('count(o.id)')->getQuery()->getSingleScalarResult();
        $totalProductTypes = $this->productTypeRepository->createQueryBuilder('o')->select('count(o.id)')->getQuery()->getSingleScalarResult();
        $totalProductManufacturers = $this->productManufacturerRepository->createQueryBuilder('o')->select('count(o.id)')->getQuery()->getSingleScalarResult();
        $totalProductImages = $this->productImageRepository->createQueryBuilder('o')->select('count(o.id)')->getQuery()->getSingleScalarResult();
        $totalCustomers = $this->customerRepository->createQueryBuilder('o')->select('count(o.id)')->getQuery()->getSingleScalarResult();
        $totalUsers = $this->userRepository->createQueryBuilder('o')->select('count(o.id)')->getQuery()->getSingleScalarResult();

        return $this->render('admin/dashboard.html.twig', [
            'totalProducts' => $totalProducts,
            'totalManufacturers' => $totalProductManufacturers,
            'totalTypes' => $totalProductTypes,
            'totalImages' => $totalProductImages,
            'totalCustomers' => $totalCustomers,
            'totalUsers' => $totalUsers
        ]);

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
            MenuItem::linkToDashboard('Dashboard', 'fa fa-chart-simple'),

            MenuItem::section('Catalog'),
            MenuItem::linkToCrud('Products', 'fa fa-tags', Product::class),
            MenuItem::linkToCrud('Product Types', 'fa fa-tags', ProductType::class),
            MenuItem::linkToCrud('Manufacturers', 'fa fa-tags', ProductManufacturer::class),

            MenuItem::section('Site'),            
            MenuItem::linkToCrud('Users', 'fa fa-users', User::class),
            MenuItem::linkToCrud('Customers', 'fa fa-building', Customer::class),

            MenuItem::linkToRoute('Update from ERP', 'fa file-import', 'app_reload_from_erp'),
        ];
    }
}
<?php

namespace App\Controller;

use App\Entity\ProductManufacturer;
use App\Entity\ProductType;
use App\Repository\ProductManufacturerRepository;
use App\Repository\ProductRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    #[Route('/catalog/{manufacturerId<\d+>?0}/{typeId<\d+>?0}/{page<\d+>?1}', name: 'app_catalog')]
    public function index(int $manufacturerId, int $typeId, int $page, Request $request, ProductRepository $repo, ProductManufacturerRepository $productManufacturerRepository): Response
    {

        $perPage = $request->get('perPage', 10);

        $qb = $repo->createQueryBuilder('p');

        if ($manufacturerId != 0) {
            $manufacturer = $productManufacturerRepository->findOneById($manufacturerId);
            $qb->andWhere('p.manufacturer = :manufacturer')->setParameter('manufacturer', $manufacturer);
        }

        $adapter = new QueryAdapter($qb);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage($adapter, $page, $perPage);

        $manufacturers = $productManufacturerRepository->findAll();

        return $this->render('catalog/index.html.twig', [
            'pager' => $pagerfanta,
            'manufacturers' => $manufacturers
        ]);
    }
}

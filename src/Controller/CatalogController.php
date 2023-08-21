<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductManufacturer;
use App\Entity\ProductType;
use App\Repository\ProductManufacturerRepository;
use App\Repository\ProductRepository;
use App\Repository\ProductTypeRepository;
use Doctrine\ORM\Query\Expr\Join;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    #[Route('/catalog/{typeId<\d+>?0}/{manufacturerId<\d+>?0}/{page<\d+>?1}', name: 'app_catalog')]
    public function index(int $manufacturerId, int $typeId, int $page, Request $request, ProductRepository $repo, ProductManufacturerRepository $productManufacturerRepository, ProductTypeRepository $productTypeRepository): Response
    {

        $perPage = $request->get('perPage', 25);

        $qb = $repo->createQueryBuilder('p');

        $manufacturer = null;

        if ($manufacturerId != 0) {
            $manufacturer = $productManufacturerRepository->findOneById($manufacturerId);
            $qb->andWhere('p.manufacturer = :manufacturer')->setParameter('manufacturer', $manufacturer);
        }

        $type = null;

        if ($typeId != 0) {
            $type = $productTypeRepository->findOneById($typeId);
            $qb->andWhere('p.type = :type')->setParameter('type', $type);
        }

        $adapter = new QueryAdapter($qb);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage($adapter, $page, $perPage);

        $productTypes = $productTypeRepository->findAll();

        if ($typeId == 0) {
            $manufacturers = $productManufacturerRepository->findAll();
        } else {
            $manufacturers = $productManufacturerRepository->createQueryBuilder('m')
            ->innerJoin('m.products', 'p', Join::WITH, 'p.type = :type')
            ->setParameter('type', $type)
            ->getQuery()->getResult();
        }

        return $this->render('catalog/index.html.twig', [
            'pager' => $pagerfanta,
            'manufacturers' => $manufacturers,
            'productTypes' => $productTypes,
            'currentManufacturer' => $manufacturer,
            'currentType' => $type,
            'options' => [
                'manufacturerId' => $manufacturerId,
                'typeId' => $typeId,
                'page' => $page
            ]
        ]);
    }

    #[Route('/catalog/{typeId<\d+>?0}/{manufacturerId<\d+>?0}/{page<\d+>?1}/{product}', name: "app_catalog_view")]
    public function view(int $manufacturerId, int $typeId, int $page, Product $product) {
        return $this->render('catalog/view.html.twig', [
            'product' => $product,
            'options' => [
                'manufacturerId' => $manufacturerId,
                'typeId' => $typeId,
                'page' => $page
            ]
        ]);
    }
}

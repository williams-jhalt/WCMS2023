<?php

namespace App\MessageHandler;

use App\Entity\Product;
use App\Entity\ProductManufacturer;
use App\Entity\ProductType;
use App\Message\InsertNewProductsFromErpMessage;
use App\Repository\ProductManufacturerRepository;
use App\Repository\ProductTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class InsertNewProductsFromErpMessageHandler
{

    public function __construct(
        private ProductTypeRepository $productTypeRepository,
        private ProductManufacturerRepository $productManufacturerRepository,
        private EntityManagerInterface $em
    ) {
    }

    public function __invoke(InsertNewProductsFromErpMessage $message)
    {

        $products = $message->getProductData();

        $conn = $this->em->getConnection();
        
        $sql = "SELECT item_number FROM product";

        $knownItemNumbers = $conn->executeQuery($sql)->fetchFirstColumn();

        foreach ($products as $productData) {

            if (array_search($productData['item_number'], $knownItemNumbers) === false) {

                $productType = $this->productTypeRepository->findOneByCode($productData['type_code']);
                if ($productType === null) {
                    $productType = new ProductType();
                    $productType->setCode($productData['type_code']);
                    $productType->setName($productData['type_code']);                    
                    $this->em->persist($productType);
                    $this->em->flush();
                }

                $productMaufacturer = $this->productManufacturerRepository->findOneByCode($productData['manufacturer_code']);
                if ($productMaufacturer === null) {
                    $productMaufacturer = new ProductManufacturer();
                    $productMaufacturer->setCode($productData['manufacturer_code']);
                    $productMaufacturer->setName($productData['manufacturer_code']);                    
                    $this->em->persist($productMaufacturer);
                    $this->em->flush();
                }

                $p = new Product();
                $p->setItemNumber($productData['item_number']);
                $p->setName($productData['name']);
                $p->setPrice($productData['wholesale_price'] * 100);
                $p->setActive($productData['active'] == "A" ? true : false);
                $p->setStockQuantity($productData['on_hand_quantity']);
                $p->setErpCreateDate(!empty($productData['date_created']) ? \DateTimeImmutable::createFromFormat('Y-m-d', $productData['date_created']) : null);
                $p->setReleaseDate(!empty($productData['release_date']) ? \DateTimeImmutable::createFromFormat('Y-m-d', $productData['date_created']) : null);
                $p->setMaxDiscountRate(!empty($productData['max_discount_rate']) ? $productData['max_discount_rate'] : null);
                $p->setSaleable($productData['saleable'] == 1 ? true : false);
                $p->setBarcode($productData['upc']);
                $p->setType($productType);
                $p->setManufacturer($productMaufacturer);
                $this->em->persist($p);
            }

        }

        $this->em->flush();
        $this->em->clear();

    }
}
<?php

namespace App\Service;

use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\ProductManufacturer;
use App\Entity\ProductType;
use App\Message\InsertNewCustomersFromErpMessage;
use App\Message\InsertNewProductsFromErpMessage;
use App\Model\ErpProduct;
use App\Repository\CustomerRepository;
use App\Repository\ProductManufacturerRepository;
use App\Repository\ProductRepository;
use App\Repository\ProductTypeRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ErpConnectorService
{

    public function __construct(
        private MessageBusInterface $bus,
        private HttpClientInterface $client,
        private ProductRepository $productRepository,
        private ProductTypeRepository $productTypeRepository,
        private ProductManufacturerRepository $productManufacturerRepository,
        private CustomerRepository $customerRepository,
        private EntityManagerInterface $em,
        private CacheInterface $cache,
        private string $erpConnectorUrl,
        private string $erpConnectorToken
    ) {
    }

    public function getProduct(string $itemNumber): ErpProduct
    {

        $product = new ErpProduct();

        return $product;

    }

    public function loadNewProducts()
    {

        $limit = 100;
        $offset = 0;
        $since = null;

        $lastProduct = $this->productRepository->createQueryBuilder("p")
            ->orderBy('p.erpCreateDate', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();

        if ($lastProduct != null) {
            $since = $lastProduct->getErpCreateDate()->format('m-d-Y');
        }

        do {

            $products = $this->client->request('GET', $this->erpConnectorUrl . "/api/product", [
                'headers' => [
                    // 'X-AUTH-TOKEN' => $this->erpConnectorToken
                ],
                'query' => [
                    'limit' => $limit,
                    'offset' => $offset,
                    'since' => $since
                ]
            ])->toArray();

            $this->bus->dispatch(new InsertNewProductsFromErpMessage($products));

            $offset = $offset + $limit;
        } while (!empty($products));
    }

    public function loadNewCustomers()
    {

        $start = 0;
        $limit = 100;
        $since = null;

        $lastCustomer = $this->customerRepository->createQueryBuilder("c")
            ->orderBy('c.dateOpened', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();

        if ($lastCustomer != null) {
            $since = $lastCustomer->getDateOpened()->format('m-d-Y');
        }

        do {

            $customers = $this->client->request(
                'GET',
                $this->erpConnectorUrl . "/api/customer",
                [
                    'query' => [
                        'offset' => $start,
                        'limit' => $limit,
                        'since' => $since
                    ],
                    'headers' => [
                        // 'X-AUTH-TOKEN' => $this->erpConnectorToken
                    ]
                ]
            )->toArray();

            $this->bus->dispatch(new InsertNewCustomersFromErpMessage($customers));

            $start = $start + $limit;
        } while (!empty($customers));
    }

    public function updateCustomer(string $customerNumber)
    {

        $cacheId = md5("refreshCustomer:$customerNumber)");

        $this->cache->get($cacheId, function (ItemInterface $item) use ($customerNumber) {

            $item->expiresAfter(3600);

            $customer = $this->client->request('GET', $this->erpConnectorUrl . "/api/customer/" . $customerNumber, [
                'headers' => [
                    // 'X-AUTH-TOKEN' => $this->erpConnectorToken
                ]
            ])->toArray();

            $c = $this->customerRepository->findOneByCustomerNumber($customer['customer_number']);

            $c->setCustomerNumber($customer['customer_number']);
            $c->setCompany($customer['name']);
            $c->setAddress1($customer['address1']);
            $c->setAddress2($customer['address2']);
            $c->setCity($customer['city']);
            $c->setState($customer['state']);
            $c->setPostalCode($customer['postal_code']);
            $c->setCountry($customer['country_code']);
            $c->setAttention($customer['attention']);
            $c->setDateOpened(DateTimeImmutable::createFromFormat('Y-m-d', $customer['date_opened']));
            $this->em->persist($c);
            $this->em->flush();
        });
    }

    public function updateProduct(string $itemNumber)
    {

        $cacheId = md5("refreshProduct:$itemNumber)");

        $this->cache->get($cacheId, function (ItemInterface $item) use ($itemNumber) {

            $item->expiresAfter(3600);

            $product = $this->client->request('GET', $this->erpConnectorUrl . "/api/product/" . $itemNumber, [
                'headers' => [
                    // 'X-AUTH-TOKEN' => $this->erpConnectorToken
                ]
            ])->toArray();


            $p = $this->productRepository->findOneByItemNumber($product['item_number']);

            if ($p === null) {
                $p = new Product();
                $p->setItemNumber($product['item_number']);
            }

            $productType = $this->productTypeRepository->findOneByCode($product['type_code']);
            if ($productType === null) {
                $productType = new ProductType();
                $productType->setCode($product['type_code']);
                $productType->setName($product['type_code']);
                $this->em->persist($productType);
                $this->em->flush();
            }

            $productMaufacturer = $this->productManufacturerRepository->findOneByCode($product['manufacturer_code']);
            if ($productMaufacturer === null) {
                $productMaufacturer = new ProductManufacturer();
                $productMaufacturer->setCode($product['manufacturer_code']);
                $productMaufacturer->setName($product['manufacturer_code']);
                $this->em->persist($productMaufacturer);
                $this->em->flush();
            }

            $p->setName($product['name']);
            $p->setPrice($product['wholesale_price'] * 100);
            $p->setActive($product['active'] == "A" ? true : false);
            $p->setStockQuantity($product['on_hand_quantity']);
            $p->setErpCreateDate(!empty($product['date_created']) ? \DateTimeImmutable::createFromFormat('Y-m-d', $product['date_created']) : null);
            $p->setReleaseDate(!empty($product['release_date']) ? \DateTimeImmutable::createFromFormat('Y-m-d', $product['date_created']) : null);
            if ($product['max_discount_rate'] !== null) {
                $p->setMaxDiscountRate($product['max_discount_rate']);
            }
            $p->setSaleable($product['saleable'] == 1 ? true : false);
            $p->setBarcode($product['upc']);
            $p->setType($productType);
            $p->setManufacturer($productMaufacturer);

            $this->em->persist($p);
            $this->em->flush();
        });
    }
}

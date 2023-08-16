<?php

namespace App\Service;

use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\ProductManufacturer;
use App\Entity\ProductType;
use App\Message\UpdateCustomerFromErpMessage;
use App\Message\UpdateProductFromErpMessage;
use App\Model\ErpCustomer;
use App\Model\ErpProduct;
use App\Repository\CustomerRepository;
use App\Repository\ProductManufacturerRepository;
use App\Repository\ProductRepository;
use App\Repository\ProductTypeRepository;
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

    public function loadNewProducts()
    {

        $limit = 500;
        $offset = 0;
        $since = null;
        $knownItemNumbers = [];

        $count = $this->productRepository->createQueryBuilder("p")->select("count(p.id)")->getQuery()->getSingleScalarResult();

        if ($count > 0) {

            $knownItemNumbers = $this->productRepository->createQueryBuilder("p")
                ->select("p.itemNumber")
                ->getQuery()
                ->getSingleColumnResult();

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

            foreach ($products as $product) {
                if (array_search($product['item_number'], $knownItemNumbers) === false) {
                    $this->bus->dispatch(new UpdateProductFromErpMessage(new ErpProduct($product)));
                }
            }

            $offset = $offset + $limit;
        } while (!empty($products));
    }

    public function loadNewCustomers()
    {

        $start = 0;
        $limit = 500;
        $since = null;
        $knownCustomerNumbers = [];

        $count = $this->customerRepository->createQueryBuilder("c")->select("count(c.id)")->getQuery()->getSingleScalarResult();

        if ($count > 0) {

            $knownCustomerNumbers = $this->customerRepository->createQueryBuilder("c")
                ->select("c.customerNumber")
                ->getQuery()
                ->getSingleColumnResult();

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

            foreach ($customers as $customer) {
                if (array_search($customer['customer_number'], $knownCustomerNumbers) === false) {
                    $this->bus->dispatch(new UpdateCustomerFromErpMessage(new ErpCustomer($customer)));
                }
            }

            $start = $start + $limit;
        } while (!empty($customers));
    }

    public function getCustomer(string $customerNumber): ErpCustomer
    {

        $cacheId = md5("ErpConnectorService:getCustomer:$customerNumber");

        $customer = $this->cache->get($cacheId, function (ItemInterface $item) use ($customerNumber) {
            $item->expiresAfter(3600);
            return $this->client->request('GET', $this->erpConnectorUrl . "/api/customer/" . $customerNumber, [
                'headers' => [
                    // 'X-AUTH-TOKEN' => $this->erpConnectorToken
                ]
            ])->toArray();
        });

        return new ErpCustomer($customer);

    }

    public function updateCustomer(ErpCustomer $customer)
    {

        $c = $this->customerRepository->findOneByCustomerNumber($customer->getCustomerNumber());

        if ($c === null) {
            $c = new Customer();
            $c->setCustomerNumber($customer->getCustomerNumber());
        }

        $c->setCompany($customer->getCompanyName());
        $c->setAddress1($customer->getAddress1());
        $c->setAddress2($customer->getAddress2());
        $c->setCity($customer->getCity());
        $c->setState($customer->getState());
        $c->setPostalCode($customer->getPostalCode());
        $c->setCountry($customer->getCountryCode());
        $c->setAttention($customer->getAttention());
        $c->setDateOpened($customer->getDateOpened());

        $this->em->persist($c);
        $this->em->flush();

    }

    public function getProduct(string $itemNumber): ErpProduct
    {

        $cacheId = md5("ErpConnectorService:getProduct:$itemNumber");

        $product = $this->cache->get($cacheId, function (ItemInterface $item) use ($itemNumber) {
            $item->expiresAfter(3900);
            return $this->client->request('GET', $this->erpConnectorUrl . "/api/product/" . $itemNumber, [
                'headers' => [
                    // 'X-AUTH-TOKEN' => $this->erpConnectorToken
                ]
            ])->toArray();
        });

        return new ErpProduct($product);

    }

    public function updateProduct(ErpProduct $product)
    {

        $p = $this->productRepository->findOneByItemNumber($product->getItemNumber());

        if ($p === null) {
            $p = new Product();
            $p->setItemNumber($product->getItemNumber());
        }

        $productType = $this->productTypeRepository->findOneByCode($product->getTypeCode());
        if ($productType === null) {
            $productType = new ProductType();
            $productType->setCode($product->getTypeCode());
            $productType->setName($product->getTypeCode());
            $this->em->persist($productType);
            $this->em->flush();
        }

        $productMaufacturer = $this->productManufacturerRepository->findOneByCode($product->getManufacturerCode());
        if ($productMaufacturer === null) {
            $productMaufacturer = new ProductManufacturer();
            $productMaufacturer->setCode($product->getManufacturerCode());
            $productMaufacturer->setName($product->getManufacturerCode());
            $this->em->persist($productMaufacturer);
            $this->em->flush();
        }

        $p->setName($product->getName());
        $p->setPrice($product->getWholesalePrice() * 100);
        $p->setActive($product->getActive());
        $p->setStockQuantity($product->getOnHandQuantity());
        $p->setErpCreateDate($product->getDateCreated());
        $p->setReleaseDate($product->getReleaseDate());
        $p->setSaleable($product->getSaleable());
        $p->setBarcode($product->getUpc());
        $p->setType($productType);
        $p->setManufacturer($productMaufacturer);

        $this->em->persist($p);
        $this->em->flush();

    }
}
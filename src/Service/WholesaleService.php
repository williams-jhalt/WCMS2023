<?php

namespace App\Service;

use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Entity\ProductImage;
use App\Entity\ProductManufacturer;
use App\Entity\ProductType;
use App\Model\WholesaleProduct;
use App\Repository\ProductCategoryRepository;
use App\Repository\ProductImageRepository;
use App\Repository\ProductManufacturerRepository;
use App\Repository\ProductRepository;
use App\Repository\ProductTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WholesaleService
{

    public function __construct(
        private HttpClientInterface $client,
        private CacheInterface $cache,
        private ProductRepository $productRepository,
        private ProductTypeRepository $productTypeRepository,
        private ProductManufacturerRepository $productManufacturerRepository,
        private ProductCategoryRepository $productCategoryRepository,
        private ProductImageRepository $productImageRepository,
        private EntityManagerInterface $entityManagerInterface,
        private LoggerInterface $logger,
        private string $wholesaleRestUrl,
        private string $imageImportDir
    ) {
    }

    public function getProduct(string $itemNumber): WholesaleProduct
    {

        $cacheId = md5("WholesaleService:getProduct:$itemNumber");

        $product = $this->cache->get($cacheId, function(ItemInterface $item) use ($itemNumber) {

            $item->expiresAfter(3600);

            $data = $this->client->request(
                'GET',
                $this->wholesaleRestUrl . "/products/" . $itemNumber,
                [
                    'query' => [
                        'format' => 'json'
                    ]
                ]
            )->toArray();

            if ($data['product'] == "Product Not Found") {
                throw new Exception();
            }
    
            return new WholesaleProduct($data['product']);

        });

        return $product;

    }

    public function updateProduct(WholesaleProduct $productData) {        

        
        $product = $this->productRepository->findOneByItemNumber($productData->getItemNumber());

        if ($product == null) {
            $product = new Product();
            $product->setItemNumber($productData->getItemNumber());
        }

        if ($productData->getName() !== null) {
            $product->setName($productData->getName());
        }

        if ($productData->getReleaseDate() !== null) {
            $product->setReleaseDate($productData->getReleaseDate());
        }

        if ($productData->getDescription() !== null) {
            $product->setDescription($productData->getDescription());
        }

        if ($productData->getKeywords() !== null) {
            $product->setKeywords($productData->getKeywords());
        }

        if ($productData->getPrice() !== null) {
            $product->setPrice($productData->getPrice());
        }

        if ($productData->getActive() !== null) {
            $product->setActive($productData->getActive());
        }

        if ($productData->getBarcode() !== null) {
            $product->setBarcode($productData->getBarcode());
        }

        if ($productData->getStockQuantity() !== null) {
            $product->setStockQuantity($productData->getStockQuantity());
        }

        if ($productData->getReorderQuantity() !== null) {
            $product->setReorderQuantity($productData->getReorderQuantity());
        }

        if ($productData->getVideo() !== null) {
            $product->setVideo($productData->getVideo());
        }

        if ($productData->getOnSale() !== null) {
            $product->setOnSale($productData->getOnSale());
        }

        if ($productData->getHeight() !== null) {
            $product->setHeight($productData->getHeight());
        }

        if ($productData->getLength() !== null) {
            $product->setLength($productData->getLength());
        }

        if ($productData->getWidth() !== null) {
            $product->setWidth($productData->getWidth());
        }

        if ($productData->getDiameter() !== null) {
            $product->setDiameter($productData->getDiameter());
        }

        if ($productData->getWeight() !== null) {
            $product->setWeight($productData->getWeight());
        }

        if ($productData->getColor() !== null) {
            $product->setColor($productData->getColor());
        }

        if ($productData->getMaterial() !== null) {
            $product->setMaterial($productData->getMaterial());
        }

        if ($productData->getDiscountable() !== null) {
            $product->setDiscountable($productData->getDiscountable());
        }

        if ($productData->getMaxDiscountRate() !== null) {
            $product->setMaxDiscountRate($productData->getMaxDiscountRate());
        }

        if ($productData->getSaleable() !== null) {
            $product->setSaleable($productData->getSaleable());
        }

        if ($productData->getInsertableLength() !== null) {
            $product->setProductLength($productData->getInsertableLength());
        }

        if ($productData->getRealistic() !== null) {
            $product->setRealistic($productData->getRealistic());
        }

        if ($productData->getBalls() !== null) {
            $product->setBalls($productData->getBalls());
        }

        if ($productData->getSuctionCup() !== null) {
            $product->setSuctionCup($productData->getSuctionCup());
        }

        if ($productData->getHarness() !== null) {
            $product->setHarness($productData->getHarness());
        }

        if ($productData->getVibrating() !== null) {
            $product->setVibrating($productData->getVibrating());
        }

        if ($productData->getThick() !== null) {
            $product->setThick($productData->getThick());
        }

        if ($productData->getDoubleEnded() !== null) {
            $product->setDoubleEnded($productData->getDoubleEnded());
        }

        if ($productData->getCircumference() !== null) {
            $product->setCircumference($productData->getCircumference());
        }

        if ($productData->getBrand() !== null) {
            $product->setBrand($productData->getBrand());
        }

        if ($productData->getMapPrice() !== null) {
            $product->setMapPrice($productData->getMapPrice());
        }

        if ($productData->getAmazonRestricted() !== null) {
            $product->setAmazonRestricted($productData->getAmazonRestricted());
        }

        if ($productData->getApprovalRequired() !== null) {
            $product->setApprovalRequired($productData->getApprovalRequired());
        }

        if ($productData->getType()->getCode() !== null) {

            $productType = $this->productTypeRepository->findOneByCode($productData->getType()->getCode());

            if ($productType == null) {
                $productType = new ProductType();
                $productType->setCode($productData->getType()->getCode());
            }

            $productType->setName($productData->getType()->getName());
            $this->entityManagerInterface->persist($productType);
            $this->entityManagerInterface->flush();

            $product->setType($productType);
        }


        if ($productData->getManufacturer()->getCode() !== null) {
            $productManufacturer = $this->productManufacturerRepository->findOneByCode($productData->getManufacturer()->getCode());

            if ($productManufacturer == null) {
                $productManufacturer = new ProductManufacturer();
                $productManufacturer->setCode($productData->getManufacturer()->getCode());
            }

            $productManufacturer->setName($productData->getManufacturer()->getName());
            $this->entityManagerInterface->persist($productManufacturer);
            $this->entityManagerInterface->flush();

            $product->setManufacturer($productManufacturer);
        }

        if (!empty($productData->getCategories())) {

            foreach ($productData->getCategories() as $c) {
                $category = $this->productCategoryRepository->findOneByCode($c->getCode());
                if ($category == null) {
                    $category = new ProductCategory();
                    $category->setCode($c->getCode());
                }

                $category->setName($c->getName());
                $this->entityManagerInterface->persist($category);
                $this->entityManagerInterface->flush();
                
                $product->addCategory($category);
            }
        }

        $this->entityManagerInterface->persist($product);
        $this->entityManagerInterface->flush();

        if (!empty($productData->getImages())) {

            $images = $this->productImageRepository->findBy(['product' => $product]);

            foreach ($productData->getImages() as $imageData) {

                $exists = false;
                foreach ($images as $i) {
                    if ($i->getImage()->getOriginalName() == $imageData->getFilename()) {
                        $this->logger->info("Image exists; skipping");
                        $exists = true;
                    }
                }

                if ($exists) {
                    continue;
                }

                $image = new ProductImage();

                $filesystem = new Filesystem();
                $filesystem->mkdir($this->imageImportDir);

                $fh = tempnam($this->imageImportDir, "image_import");

                $this->logger->info("Creating temporary file " . $fh);

                if (false !== file_put_contents($fh, file_get_contents($imageData->getImageUrl()))) {
                    $image->setImageFile(new UploadedFile($fh, $imageData->getFilename(), null, null, true));
                    $image->setProduct($product);
                    $this->entityManagerInterface->persist($image);
                    $this->entityManagerInterface->flush();

                    $this->logger->info("Added new image file " . $image->getImage()->getName());
                }

            }

        }

        return $product;

    }

}

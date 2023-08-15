<?php

namespace App\Service;

use App\Entity\Product;
use App\Model\WholesaleProduct;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WholesaleService
{

    public function __construct(
        private HttpClientInterface $client,
        private CacheInterface $cache,
        private string $wholesaleRestUrl
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
    
            return new WholesaleProduct($data);

        });

        return $product;

    }

    public function updateProduct(Product $product) {

        $wholesaleProduct = $this->getProduct($product->getItemNumber());

    }

}

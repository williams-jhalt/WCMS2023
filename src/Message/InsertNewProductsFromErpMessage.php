<?php

namespace App\Message;

final class InsertNewProductsFromErpMessage
{

    private $productData;

    public function __construct(array $productData) {
        $this->productData = $productData;
    }

    public function getProductData(): array
    {
        return $this->productData;
    }
    
}

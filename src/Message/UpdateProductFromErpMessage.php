<?php

namespace App\Message;
use App\Model\ErpProduct;

final class UpdateProductFromErpMessage
{

    private $product;

    public function __construct(ErpProduct $product) {
        $this->product = $product;
    }

    public function getProduct(): ErpProduct
    {
        return $this->product;
    }
    
}

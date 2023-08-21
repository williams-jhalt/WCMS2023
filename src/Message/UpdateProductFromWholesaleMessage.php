<?php

namespace App\Message;
use App\Model\WholesaleProduct;

final class UpdateProductFromWholesaleMessage
{

    private $product;

    public function __construct(WholesaleProduct $product) {
        $this->product = $product;
    }

    public function getProduct(): WholesaleProduct {
        return $this->product;
    }
    
}

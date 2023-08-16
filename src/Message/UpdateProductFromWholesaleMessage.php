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
    /*
     * Add whatever properties and methods you need
     * to hold the data for this message class.
     */

//     private $name;

//     public function __construct(string $name)
//     {
//         $this->name = $name;
//     }

//    public function getName(): string
//    {
//        return $this->name;
//    }
}

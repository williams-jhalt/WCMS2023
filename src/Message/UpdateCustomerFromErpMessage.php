<?php

namespace App\Message;
use App\Model\ErpCustomer;

final class UpdateCustomerFromErpMessage
{

    private $customer;

    public function __construct(ErpCustomer $customer) {
        $this->customer = $customer;
    }

    public function getCustomer(): ErpCustomer
    {
        return $this->customer;
    }
    
}

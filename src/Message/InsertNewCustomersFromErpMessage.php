<?php

namespace App\Message;

final class InsertNewCustomersFromErpMessage
{

    private $customerData;

    public function __construct(array $customerData) {
        $this->customerData = $customerData;
    }

    public function getCustomerData(): array
    {
        return $this->customerData;
    }
    
}

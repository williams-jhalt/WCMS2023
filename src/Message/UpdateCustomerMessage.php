<?php

namespace App\Message;

final class UpdateCustomerMessage
{

    private $customerNumber;

    public function __construct(string $customerNumber) {
        $this->customerNumber = $customerNumber;        
    }

    public function getCustomerNumber() {
        return $this->customerNumber;
    }
    
}

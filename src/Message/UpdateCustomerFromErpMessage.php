<?php

namespace App\Message;

final class UpdateCustomerFromErpMessage
{

    private $customerNumber;

    public function __construct(string $customerNumber) {
        $this->customerNumber = $customerNumber;
    }

    public function getCustomerNumber() {
        return $this->customerNumber;
    }
}

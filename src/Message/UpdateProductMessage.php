<?php

namespace App\Message;

final class UpdateProductMessage
{

    private $itemNumber;

    public function __construct(string $itemNumber) {
        $this->itemNumber = $itemNumber;
    }

    public function getItemNumber() {
        return $this->itemNumber;
    }

}

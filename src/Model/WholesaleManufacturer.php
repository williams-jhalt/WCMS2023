<?php

namespace App\Model;

class WholesaleManufacturer {
    private $code;
    private $name;

    public function __construct(array $data = null) {
        if ($data !== null) {
            $this->code = $data['code'];
            $this->name = $data['name'];
        }
    }

    public function getCode() {
        return $this->code;        
    }

    public function setCode(string $code) {
        $this->code = $code;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName(string $name) {
        $this->name = $name;
        return $this;
    }
}
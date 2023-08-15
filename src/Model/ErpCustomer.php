<?php

namespace App\Model;

use DateTimeImmutable;
use DateTimeInterface;

class ErpCustomer {

    private $customerNumber;
    private $companyName;
    private $address1;
    private $address2;
    private $city;
    private $state;
    private $postalCode;
    private $countryCode;
    private $attention;
    private $dateOpened;

    public function __construct(array $data = null) {
        if ($data !== null) {
            $this->customerNumber = $data['customer_number'];
            $this->companyName = $data['name'];
            $this->address1 = $data['address1'];
            $this->address2 = $data['address2'];
            $this->city = $data['city'];
            $this->state = $data['state'];
            $this->postalCode = $data['postal_code'];
            $this->countryCode = $data['country_code'];
            $this->attention = $data['attention'];
            $this->dateOpened = DateTimeImmutable::createFromFormat('Y-m-d', $data['date_opened']);
        }
    }
    
    public function getCustomerNumber() {
        return $this->customerNumber;
    }

    public function setCustomerNumber(string $customerNumber) {
        $this->customerNumber = $customerNumber;
        return $this;
    }
    
    public function getCompanyName() {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName) {
        $this->companyName = $companyName;
        return $this;
    }

    public function getAddress1() {
        return $this->address1;
    }

    public function setAddress1(string $address1) {
        $this->address1 = $address1;
        return $this;
    }

    public function getAddress2() {
        return $this->address2;
    }

    public function setAddress2(string $address2) {
        $this->address2 = $address2;
        return $this;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity(string $city) {
        $this->city = $city;
        return $this;
    }

    public function getState() {
        return $this->state;
    }

    public function setState(string $state) {
        $this->state = $state;
        return $this;
    }

    public function getPostalCode() {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode) {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function getCountryCode() {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode) {
        $this->countryCode = $countryCode;
        return $this;
    }

    public function getAttention() {
        return $this->attention;
    }

    public function setAttention(string $attention) {
        $this->attention = $attention;
        return $this;
    }

    public function getDateOpened() {
        return $this->dateOpened;
    }

    public function setDateOpened(DateTimeInterface $dateOpened) {
        $this->dateOpened = $dateOpened;
        return $this;
    }

}
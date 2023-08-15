<?php 

namespace App\Model;

use DateTimeImmutable;
use DateTimeInterface;

class ErpProduct {
    
    private $itemNumber;
    private $typeCode;
    private $manufacturerCode;
    private $name;
    private $wholesalePrice;
    private $active;
    private $onHandQuantity;
    private $dateCreated;
    private $releaseDate;
    private $maxDiscountRate;
    private $saleable;
    private $upc;

    public function __construct(array $data = null) {
        if ($data !== null) {
            $this->itemNumber = $data['item_number'];
            $this->typeCode = $data['type_code'];
            $this->manufacturerCode = $data['manufacturer_code'];
            $this->name = $data['name'];
            $this->wholesalePrice = $data['wholesale_price'];
            $this->active = ($data['active'] == 'A' ? true : false);
            $this->onHandQuantity = $data['on_hand_quantity'];
            $this->dateCreated = DateTimeImmutable::createFromFormat('Y-m-d', $data['date_created']);
            if (!empty($data['release_date'])) {
                $this->releaseDate = DateTimeImmutable::createFromFormat('Y-m-d', $data['release_date']);
            }
            $this->maxDiscountRate = $data['max_discount_rate'];
            $this->saleable = (bool) $data['saleable'];
            $this->upc = $data['upc'];
        }
    }
    

    /**
     * Get the value of itemNumber
     */ 
    public function getItemNumber()
    {
        return $this->itemNumber;
    }

    /**
     * Set the value of itemNumber
     *
     * @return  self
     */ 
    public function setItemNumber($itemNumber)
    {
        $this->itemNumber = $itemNumber;

        return $this;
    }

    /**
     * Get the value of typeCode
     */ 
    public function getTypeCode()
    {
        return $this->typeCode;
    }

    /**
     * Set the value of typeCode
     *
     * @return  self
     */ 
    public function setTypeCode($typeCode)
    {
        $this->typeCode = $typeCode;

        return $this;
    }

    /**
     * Get the value of manufacturerCode
     */ 
    public function getManufacturerCode()
    {
        return $this->manufacturerCode;
    }

    /**
     * Set the value of manufacturerCode
     *
     * @return  self
     */ 
    public function setManufacturerCode($manufacturerCode)
    {
        $this->manufacturerCode = $manufacturerCode;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of wholesalePrice
     */ 
    public function getWholesalePrice()
    {
        return $this->wholesalePrice;
    }

    /**
     * Set the value of wholesalePrice
     *
     * @return  self
     */ 
    public function setWholesalePrice($wholesalePrice)
    {
        $this->wholesalePrice = $wholesalePrice;

        return $this;
    }

    /**
     * Get the value of active
     */ 
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the value of active
     *
     * @return  self
     */ 
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get the value of onHandQuantity
     */ 
    public function getOnHandQuantity()
    {
        return $this->onHandQuantity;
    }

    /**
     * Set the value of onHandQuantity
     *
     * @return  self
     */ 
    public function setOnHandQuantity($onHandQuantity)
    {
        $this->onHandQuantity = $onHandQuantity;

        return $this;
    }

    /**
     * Get the value of dateCreated
     */ 
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set the value of dateCreated
     *
     * @return  self
     */ 
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get the value of releaseDate
     */ 
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Set the value of releaseDate
     *
     * @return  self
     */ 
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get the value of maxDiscountRate
     */ 
    public function getMaxDiscountRate()
    {
        return $this->maxDiscountRate;
    }

    /**
     * Set the value of maxDiscountRate
     *
     * @return  self
     */ 
    public function setMaxDiscountRate($maxDiscountRate)
    {
        $this->maxDiscountRate = $maxDiscountRate;

        return $this;
    }

    /**
     * Get the value of saleable
     */ 
    public function getSaleable()
    {
        return $this->saleable;
    }

    /**
     * Set the value of saleable
     *
     * @return  self
     */ 
    public function setSaleable($saleable)
    {
        $this->saleable = $saleable;

        return $this;
    }

    /**
     * Get the value of upc
     */ 
    public function getUpc()
    {
        return $this->upc;
    }

    /**
     * Set the value of upc
     *
     * @return  self
     */ 
    public function setUpc($upc)
    {
        $this->upc = $upc;

        return $this;
    }
}
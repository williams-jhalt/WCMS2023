<?php

namespace App\Model;

use DateTimeImmutable;
use DateTimeInterface;

class WholesaleProduct
{

    private string $itemNumber;
    private ?string $name;
    private ?WholesaleType $type;
    private ?WholesaleManufacturer $manufacturer;
    private ?array $categories;
    private ?DateTimeInterface $releaseDate;
    private ?string $description;
    private ?string $keywords;
    private ?float $price;
    private ?bool $active;
    private ?string $barcode;
    private ?int $stockQuantity;
    private ?int $reorderQuantity;
    private ?bool $video;
    private ?bool $onSale;
    private ?float $height;
    private ?float $length;
    private ?float $width;
    private ?float $diameter;
    private ?float $weight;
    private ?string $color;
    private ?string $material;
    private ?bool $discountable;
    private ?float $maxDiscountRate;
    private ?bool $saleable;
    private ?float $productLength;
    private ?float $insertableLength;
    private ?bool $realistic;
    private ?bool $balls;
    private ?bool $suctionCup;
    private ?bool $harness;
    private ?bool $vibrating;
    private ?bool $thick;
    private ?bool $doubleEnded;
    private ?float $circumference;
    private ?string $brand;
    private ?float $mapPrice;
    private ?bool $amazonRestricted;
    private ?bool $approvalRequired;
    private ?array $images;
    private ?DateTimeInterface $createdOn;
    private ?DateTimeInterface $updatedOn;
    
    public function __construct(array $data = null) {
        $this->images = [];
        $this->categories = [];        

        if ($data !== null) {
            $this->itemNumber = $data['sku'];
            $this->name = $data['name'];
            $this->description = $data['description'];
            $this->keywords = $data['keywords'];
            $this->price = $data['price'];
            $this->active = $data['active'];
            $this->barcode = $data['barcode'];
            $this->stockQuantity = $data['stock_quantity'];
            $this->reorderQuantity = $data['reorder_quantity'];
            $this->video = $data['video'];
            $this->onSale = $data['on_sale'];
            $this->height = $data['height'];
            $this->length = $data['length'];
            $this->width = $data['width'];
            $this->diameter = $data['diameter'];
            $this->weight = $data['weight'];
            $this->color = $data['color'];
            $this->material = $data['material'];
            $this->releaseDate = DateTimeImmutable::createFromFormat('Y-m-d', $data['release_date']);
            $this->discountable = $data['discountable'];
            $this->saleable = $data['saleable'];
            $this->productLength = $data['product_length'];
            $this->insertableLength = $data['insertable_length'];
            $this->realistic = $data['realistic'];
            $this->balls = $data['balls'];
            $this->suctionCup = $data['suction_cup'];
            $this->harness = $data['harness'];
            $this->maxDiscountRate = $data['max_discount_rate'];
            $this->vibrating = $data['vibrating'];
            $this->thick = $data['thick'];
            $this->doubleEnded = $data['double_ended'];
            $this->circumference = $data['circumference'];
            $this->brand = $data['brand'];
            $this->mapPrice = $data['map_price'];
            $this->amazonRestricted = $data['amazon_restricted'];
            $this->approvalRequired = $data['approval_required'];
            $this->type = new WholesaleType($data['type']);
            $this->manufacturer = new WholesaleManufacturer($data['type']);
            if (!empty($data['created_on'])) {
                $this->createdOn = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['created_on']);
            }

            if (!empty($data['updated_on'])) {
                $this->updatedOn = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['updated_on']);
            }

            if (!empty($data['categories'])) {
                foreach ($data['categories'] as $category) {
                    $this->categories[] = new WholesaleCategory($category);
                }
            }

            if (!empty($data['images'])) {
                foreach ($data['images'] as $image) {
                    $this->images[] = new WholesaleImage($image);
                }
            }

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
    public function setItemNumber(string $itemNumber)
    {
        $this->itemNumber = $itemNumber;

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
    public function setName(?string $name)
    {
        $this->name = $name;

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
    public function setReleaseDate(?DateTimeInterface $releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription(?string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of keywords
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set the value of keywords
     *
     * @return  self
     */
    public function setKeywords(?string $keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */
    public function setPrice(?float $price)
    {
        $this->price = $price;

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
    public function setActive(?bool $active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get the value of barcode
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * Set the value of barcode
     *
     * @return  self
     */
    public function setBarcode(?string $barcode)
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * Get the value of stockQuantity
     */
    public function getStockQuantity()
    {
        return $this->stockQuantity;
    }

    /**
     * Set the value of stockQuantity
     *
     * @return  self
     */
    public function setStockQuantity(?int $stockQuantity)
    {
        $this->stockQuantity = $stockQuantity;

        return $this;
    }

    /**
     * Get the value of reorderQuantity
     */
    public function getReorderQuantity()
    {
        return $this->reorderQuantity;
    }

    /**
     * Set the value of reorderQuantity
     *
     * @return  self
     */
    public function setReorderQuantity(?int $reorderQuantity)
    {
        $this->reorderQuantity = $reorderQuantity;

        return $this;
    }

    /**
     * Get the value of video
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set the value of video
     *
     * @return  self
     */
    public function setVideo(?bool $video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get the value of onSale
     */
    public function getOnSale()
    {
        return $this->onSale;
    }

    /**
     * Set the value of onSale
     *
     * @return  self
     */
    public function setOnSale(?bool $onSale)
    {
        $this->onSale = $onSale;

        return $this;
    }

    /**
     * Get the value of height
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set the value of height
     *
     * @return  self
     */
    public function setHeight(?float $height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get the value of length
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set the value of length
     *
     * @return  self
     */
    public function setLength(?float $length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get the value of width
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set the value of width
     *
     * @return  self
     */
    public function setWidth(?float $width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get the value of diameter
     */
    public function getDiameter()
    {
        return $this->diameter;
    }

    /**
     * Set the value of diameter
     *
     * @return  self
     */
    public function setDiameter(?float $diameter)
    {
        $this->diameter = $diameter;

        return $this;
    }

    /**
     * Get the value of weight
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set the value of weight
     *
     * @return  self
     */
    public function setWeight(?float $weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get the value of color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set the value of color
     *
     * @return  self
     */
    public function setColor(?string $color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get the value of material
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * Set the value of material
     *
     * @return  self
     */
    public function setMaterial(?string $material)
    {
        $this->material = $material;

        return $this;
    }

    /**
     * Get the value of discountable
     */
    public function getDiscountable()
    {
        return $this->discountable;
    }

    /**
     * Set the value of discountable
     *
     * @return  self
     */
    public function setDiscountable(?bool $discountable)
    {
        $this->discountable = $discountable;

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
    public function setMaxDiscountRate(?float $maxDiscountRate)
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
    public function setSaleable(?bool $saleable)
    {
        $this->saleable = $saleable;

        return $this;
    }

    /**
     * Get the value of productLength
     */
    public function getProductLength()
    {
        return $this->productLength;
    }

    /**
     * Set the value of productLength
     *
     * @return  self
     */
    public function setProductLength(?float $productLength)
    {
        $this->productLength = $productLength;

        return $this;
    }

    /**
     * Get the value of insertableLength
     */
    public function getInsertableLength()
    {
        return $this->insertableLength;
    }

    /**
     * Set the value of insertableLength
     *
     * @return  self
     */
    public function setInsertableLength(?float $insertableLength)
    {
        $this->insertableLength = $insertableLength;

        return $this;
    }

    /**
     * Get the value of realistic
     */
    public function getRealistic()
    {
        return $this->realistic;
    }

    /**
     * Set the value of realistic
     *
     * @return  self
     */
    public function setRealistic(?bool $realistic)
    {
        $this->realistic = $realistic;

        return $this;
    }

    /**
     * Get the value of balls
     */
    public function getBalls()
    {
        return $this->balls;
    }

    /**
     * Set the value of balls
     *
     * @return  self
     */
    public function setBalls(?bool $balls)
    {
        $this->balls = $balls;

        return $this;
    }

    /**
     * Get the value of suctionCup
     */
    public function getSuctionCup()
    {
        return $this->suctionCup;
    }

    /**
     * Set the value of suctionCup
     *
     * @return  self
     */
    public function setSuctionCup(?bool $suctionCup)
    {
        $this->suctionCup = $suctionCup;

        return $this;
    }

    /**
     * Get the value of harness
     */
    public function getHarness()
    {
        return $this->harness;
    }

    /**
     * Set the value of harness
     *
     * @return  self
     */
    public function setHarness(?bool $harness)
    {
        $this->harness = $harness;

        return $this;
    }

    /**
     * Get the value of vibrating
     */
    public function getVibrating()
    {
        return $this->vibrating;
    }

    /**
     * Set the value of vibrating
     *
     * @return  self
     */
    public function setVibrating(?bool $vibrating)
    {
        $this->vibrating = $vibrating;

        return $this;
    }

    /**
     * Get the value of thick
     */
    public function getThick()
    {
        return $this->thick;
    }

    /**
     * Set the value of thick
     *
     * @return  self
     */
    public function setThick(?bool $thick)
    {
        $this->thick = $thick;

        return $this;
    }

    /**
     * Get the value of doubleEnded
     */
    public function getDoubleEnded()
    {
        return $this->doubleEnded;
    }

    /**
     * Set the value of doubleEnded
     *
     * @return  self
     */
    public function setDoubleEnded(?bool $doubleEnded)
    {
        $this->doubleEnded = $doubleEnded;

        return $this;
    }

    /**
     * Get the value of brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set the value of brand
     *
     * @return  self
     */
    public function setBrand(?string $brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get the value of circumference
     */
    public function getCircumference()
    {
        return $this->circumference;
    }

    /**
     * Set the value of circumference
     *
     * @return  self
     */
    public function setCircumference(?float $circumference)
    {
        $this->circumference = $circumference;

        return $this;
    }

    /**
     * Get the value of mapPrice
     */
    public function getMapPrice()
    {
        return $this->mapPrice;
    }

    /**
     * Set the value of mapPrice
     *
     * @return  self
     */
    public function setMapPrice(?float $mapPrice)
    {
        $this->mapPrice = $mapPrice;

        return $this;
    }

    /**
     * Get the value of amazonRestricted
     */
    public function getAmazonRestricted()
    {
        return $this->amazonRestricted;
    }

    /**
     * Set the value of amazonRestricted
     *
     * @return  self
     */
    public function setAmazonRestricted(?bool $amazonRestricted)
    {
        $this->amazonRestricted = $amazonRestricted;

        return $this;
    }

    /**
     * Get the value of approvalRequired
     */
    public function getApprovalRequired()
    {
        return $this->approvalRequired;
    }

    /**
     * Set the value of approvalRequired
     *
     * @return  self
     */
    public function setApprovalRequired(?bool $approvalRequired)
    {
        $this->approvalRequired = $approvalRequired;

        return $this;
    }

    /**
     * Get the value of images
     */ 
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set the value of images
     *
     * @return  self
     */ 
    public function setImages(?array $images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get the value of manufacturer
     */ 
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Set the value of manufacturer
     *
     * @return  self
     */ 
    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of categories
     */ 
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set the value of categories
     *
     * @return  self
     */ 
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }


    /**
     * Get the value of createdOn
     */ 
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set the value of createdOn
     *
     * @return  self
     */ 
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get the value of updatedOn
     */ 
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * Set the value of updatedOn
     *
     * @return  self
     */ 
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }
}

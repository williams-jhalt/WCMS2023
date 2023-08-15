<?php

namespace App\Model;

class WholesaleImage {

    private $filename;
    private $imageUrl;
    private $altText;
    private $description;
    private $explicit;
    private $primary;

    public function __construct(array $data = null) {
        if ($data !== null) {
            $this->filename = $data['filename'];
            $this->imageUrl = $data['image_url'];
            $this->altText = $data['alt_text'];
            $this->description = $data['description'];
            $this->explicit = $data['explicit'];
            $this->primary = $data['primary'];
        }
    }

    public function getFilename() {
        return $this->filename;
    }

    public function setFilename(string $filename) {
        $this->filename = $filename;
        return $this;
    }

    public function getImageUrl() {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl) {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    public function getAltText() {
        return $this->altText;
    }

    public function setAltText(string $altText) {
        $this->altText = $altText;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription(string $description) {
        $this->description = $description;
        return $this;
    }

    public function getExplicit() {
        return $this->explicit;
    }

    public function setExplicit(bool $explicit) {
        $this->explicit = $explicit;
        return $this;
    }

    public function getPrimary() {
        return $this->primary;
    }

    public function setPrimary(bool $primary) {
        $this->primary = $primary;
        return $this;
    }

}
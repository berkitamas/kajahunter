<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 26.
 * Time: 23:07
 */

namespace App\Model;

use App\Core\AsArray;

class Restaurant extends Account {
    /**
     * @get getCompanyName
     * @set setCompanyName
     * @var string
     */
    private $company_name;

    /**
     * @get getPostcode
     * @set setPostcode
     * @var null|string
     */
    private $postcode;

    /**
     * @get getCity
     * @set setCity
     * @var null|string
     */
    private $city;

    /**
     * @get getStreet
     * @set setStreet
     * @var null|string
     */
    private $street;

    /**
     * @get getAddress
     * @set setAddress
     * @var null|string
     */
    private $address;

    /**
     * @get getLogoFile
     * @set setLogoFile
     * @var null|string
     */
    private $logo_file;

    /**
     * @get getCoverFile
     * @set setCoverFile
     * @var null|string
     */
    private $cover_file;

    /**
     * @get getCuisine
     * @set setCuisine
     * @var null|string
     */
    private $cuisine;

    /**
     * @get getOpenFrom
     * @set setOpenFrom
     * @var null|int
     */
    private $open_from;

    /**
     * @get getOpenTo
     * @set setOpenTo
     * @var null|int
     */
    private $open_to;

    /**
     * @get getDeliveryTime
     * @set setDeliveryTime
     * @var null|string
     */
    private $delivery_time;

    /**
     * @return string
     */
    public function getCompanyName(): string {
        return $this->company_name;
    }

    /**
     * @param string $company_name
     */
    public function setCompanyName(string $company_name): void {
        $this->company_name = $company_name;
    }

    /**
     * @return null|string
     */
    public function getPostcode(): ?string {
        return $this->postcode;
    }

    /**
     * @param null|string $postcode
     */
    public function setPostcode(?string $postcode): void {
        $this->postcode = $postcode;
    }

    /**
     * @return null|string
     */
    public function getCity(): ?string {
        return $this->city;
    }

    /**
     * @param null|string $city
     */
    public function setCity(?string $city): void {
        $this->city = $city;
    }

    /**
     * @return null|string
     */
    public function getStreet(): ?string {
        return $this->street;
    }

    /**
     * @param null|string $street
     */
    public function setStreet(?string $street): void {
        $this->street = $street;
    }

    /**
     * @return null|string
     */
    public function getAddress(): ?string {
        return $this->address;
    }

    /**
     * @param null|string $address
     */
    public function setAddress(?string $address): void {
        $this->address = $address;
    }

    /**
     * @return null|string
     */
    public function getLogoFile(): ?string {
        return $this->logo_file;
    }

    /**
     * @param null|string $logo_file
     */
    public function setLogoFile(?string $logo_file): void {
        $this->logo_file = $logo_file;
    }

    /**
     * @return null|string
     */
    public function getCoverFile(): ?string {
        return $this->cover_file;
    }

    /**
     * @param null|string $cover_file
     */
    public function setCoverFile(?string $cover_file): void {
        $this->cover_file = $cover_file;
    }

    /**
     * @return null|string
     */
    public function getCuisine(): ?string {
        return $this->cuisine;
    }

    /**
     * @param null|string $cuisine
     */
    public function setCuisine(?string $cuisine): void {
        $this->cuisine = $cuisine;
    }

    /**
     * @return int|null
     */
    public function getOpenFrom(): ?int {
        return $this->open_from;
    }

    /**
     * @param int|null $open_from
     */
    public function setOpenFrom(?int $open_from): void {
        $this->open_from = $open_from;
    }

    /**
     * @return int|null
     */
    public function getOpenTo(): ?int {
        return $this->open_to;
    }

    /**
     * @param int|null $open_to
     */
    public function setOpenTo(?int $open_to): void {
        $this->open_to = $open_to;
    }

    /**
     * @return bool
     */
    public function isNonStop(): bool {
        return ($this->open_from === null || $this->open_to === null || $this->open_from == $this->open_to);
    }

    /**
     * @return null|string
     */
    public function getDeliveryTime(): ?string {
        return $this->delivery_time;
    }

    /**
     * @param null|string $delivery_time
     */
    public function setDeliveryTime(?string $delivery_time): void {
        $this->delivery_time = $delivery_time;
    }
}
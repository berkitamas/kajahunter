<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 26.
 * Time: 23:08
 */

namespace App\Model;


use App\Core\AsArray;

class Address extends AsArray implements CommonModel {

    /**
     * @get getId
     * @set setId
     * @var int
     */
    private $id;
    /**
     * @get getConsumerId
     * @set setConsumerId
     * @var int
     */
    private $consumer_id;
    /**
     * @get getAlias
     * @set setAlias
     * @var string
     */
    private $alias;
    /**
     * @get getPostcode
     * @set setPostcode
     * @var string
     */
    private $postcode;
    /**
     * @get getCity
     * @set setCity
     * @var string
     */
    private $city;
    /**
     * @get getStreet
     * @set setStreet
     * @var string
     */
    private $street;
    /**
     * @get getAddress
     * @set setAddress
     * @var string
     */
    private $address;

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getConsumerId(): int {
        return $this->consumer_id;
    }

    /**
     * @param int $consumer_id
     */
    public function setConsumerId(int $consumer_id): void {
        $this->consumer_id = $consumer_id;
    }

    /**
     * @return string
     */
    public function getAlias(): string {
        return $this->alias;
    }

    /**
     * @param string $alias
     */
    public function setAlias(string $alias): void {
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function getPostcode(): string {
        return $this->postcode;
    }

    /**
     * @param string $postcode
     */
    public function setPostcode(string $postcode): void {
        $this->postcode = $postcode;
    }

    /**
     * @return string
     */
    public function getCity(): string {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getStreet(): string {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): void {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getAddress(): string {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void {
        $this->address = $address;
    }
}
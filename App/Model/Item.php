<?php
/**
 * Created by PhpStorm.
 * User: thomastopies
 * Date: 2018. 03. 26.
 * Time: 21:26
 */

namespace App\Model;


use App\Core\AsArray;

class Item extends AsArray implements CommonModel {
    /**
     * @get getId
     * @set setId
     * @var int
     */
    private $id;
    /**
     * @get getCategoryId
     * @set setCategoryId
     * @var int
     */
    private $category_id;
    /**
     * @get getName
     * @set @setName
     * @var string
     */
    private $name;
    /**
     * @get getString
     * @set setString
     * @var string
     */
    private $desc;
    /**
     * @get getPhotoFile
     * @set setPhotoFile
     * @var string|null
     */
    private $photo_file;
    /**
     *
     * bc_math
     *
     * @get getPrice
     * @set setPrice
     *
     * @var string
     */
    private $price;

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
    public function getCategoryId(): int {
        return $this->category_id;
    }

    /**
     * @param int $category_id
     */
    public function setCategoryId(int $category_id): void {
        $this->category_id = $category_id;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDesc(): string {
        return $this->desc;
    }

    /**
     * @param string $desc
     */
    public function setDesc(string $desc): void {
        $this->desc = $desc;
    }

    /**
     * @return null|string
     */
    public function getPhotoFile(): ?string {
        return $this->photo_file;
    }

    /**
     * @param null|string $photo_file
     */
    public function setPhotoFile(?string $photo_file): void {
        $this->photo_file = $photo_file;
    }

    /**
     * @return string
     */
    public function getPrice(): string {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price): void {
        $this->price = $price;
    }
}
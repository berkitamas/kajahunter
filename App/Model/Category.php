<?php
/**
 * Created by PhpStorm.
 * User: thomastopies
 * Date: 2018. 03. 26.
 * Time: 21:26
 */

namespace App\Model;


use App\Core\AsArray;

class Category extends AsArray implements CommonModel {
    /**
     * @get getId
     * @set setId
     * @var int
     */
    private $id;
    /**
     * @get getProducerId
     * @set setProducerId
     * @var int
     */
    private $producer_id;
    /**
     * @get getName
     * @set setName
     * @var string
     */
    private $name;

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
    public function getProducerId(): int {
        return $this->producer_id;
    }

    /**
     * @param int $producer_id
     */
    public function setProducerId(int $producer_id): void {
        $this->producer_id = $producer_id;
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
}
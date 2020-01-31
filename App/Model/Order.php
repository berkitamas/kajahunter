<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 27.
 * Time: 16:08
 */

namespace App\Model;


use App\Core\AsArray;

class Order extends AsArray implements CommonModel {

    /**
     * @get getId
     * @set setId
     * @var int
     */
    private $id;

    /**
     * @get getRestaurantId
     * @set setRestaurantId
     * @var int
     */
    private $restaurant_id;

    /**
     * @get getConsuemrId
     * @set setConsumerId
     * @var int
     */
    private $consumer_id;

    /**
     * @get getAddressId
     * @set setAddressId
     * @var int
     */
    private $address_id;

    /**
     * @get isCompleted
     * @var bool
     */
    private $completed;

    /**
     * @get getItemsJSON
     * @set setItems
     * @var string
     */
    private $items;

    /**
     * @get getOrderDate
     * @set setOrderDate
     * @var int
     */
    private $order_date;

    /**
     * @get getCompleteDate
     * @set setCompleteDate
     * @var null|int
     */
    private $complete_date;

    /**
     * @get getSum
     * @set setSum
     * @var string
     */
    private $sum;

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
    public function getRestaurantId(): int {
        return $this->restaurant_id;
    }

    /**
     * @param int $restaurant_id
     */
    public function setRestaurantId(int $restaurant_id): void {
        $this->restaurant_id = $restaurant_id;
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
     * @return int
     */
    public function getAddressId(): int {
        return $this->address_id;
    }

    /**
     * @param int $address_id
     */
    public function setAddressId(int $address_id): void {
        $this->address_id = $address_id;
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool {
        return !empty($this->getCompleteDate());
    }

    public function getItemsJSON(): string {
        return $this->items;
    }

    /**
     * @return array
     */
    public function getItems(): array {
        return json_decode((!is_null($this->items))?$this->items:[], true);
    }

    /**
     * @param string $items
     */
    public function setItems(string $items): void {
        $this->items = json_encode($items);
    }

    /**
     * @return int
     */
    public function getOrderDate(): int {
        return $this->order_date;
    }

    /**
     * @param int $order_date
     */
    public function setOrderDate(int $order_date): void {
        $this->order_date = $order_date;
    }

    /**
     * @return int|null
     */
    public function getCompleteDate(): ?int {
        return $this->complete_date;
    }

    /**
     * @param int|null $complete_date
     */
    public function setCompleteDate(?int $complete_date): void {
        $this->complete_date = $complete_date;
    }

    /**
     * @return string
     */
    public function getSum(): string {
        return $this->sum;
    }

    /**
     * @param string $sum
     */
    public function setSum(string $sum): void {
        $this->sum = $sum;
    }
}
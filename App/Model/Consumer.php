<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 26.
 * Time: 23:07
 */

namespace App\Model;

class Consumer extends Account {
    /**
     * @get getFirstName
     * @set setFirstName
     * @var string
     */
    private $first_name;

    /**
     * @get getLastName
     * @set setLastName
     * @var string
     */
    private $last_name;

    /**
     * @get getBirthYear
     * @set setBirthYear
     * @var int|null
     */
    private $birth_year;

    /**
     * @get getBirthMonth
     * @set setBirthMonth
     * @var int|null
     */
    private $birth_month;

    /**
     * @get getBirthDay
     * @set setBirthDay
     * @var int|null
     */
    private $birth_day;

    /**
     * @return string
     */
    public function getFirstName(): string {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName(string $first_name): void {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName(string $last_name): void {
        $this->last_name = $last_name;
    }

    /**
     * @return int|null
     */
    public function getBirthYear(): ?int {
        return $this->birth_year;
    }

    /**
     * @param int|null $birth_year
     */
    public function setBirthYear(?int $birth_year): void {
        $this->birth_year = $birth_year;
    }

    /**
     * @return int|null
     */
    public function getBirthMonth(): ?int {
        return $this->birth_month;
    }

    /**
     * @param int|null $birth_month
     */
    public function setBirthMonth(?int $birth_month): void {
        $this->birth_month = $birth_month;
    }

    /**
     * @return int|null
     */
    public function getBirthDay(): ?int {
        return $this->birth_day;
    }

    /**
     * @param int|null $birth_day
     */
    public function setBirthDay(?int $birth_day): void {
        $this->birth_day = $birth_day;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 27.
 * Time: 14:56
 */

namespace App\Model;


use App\Core\AsArray;

abstract class Account extends AsArray  implements CommonModel {
    /**
     * @get getId
     * @set setId
     * @var int
     */
    protected $id;

    /**
     * @get getEmail
     * @set setEmail
     * @var string
     */
    protected $email;

    /**
     * @get getEmailActivation
     * @set setEmailActivation
     * @var string
     */
    protected $email_activation;

    /**
     * @get isActivated
     * @var bool
     */
    protected $activated;

    /**
     * @get getPassword
     * @set setPassword
     * @var string
     */
    protected $password;

    /**
     * @get getForgottenPassword
     * @set setForgottenPassword
     * @var null|string
     */
    protected $forgotten_password;

    /**
     * @get getPhone
     * @set setPhone
     * @var int
     */
    protected $phone;


    /**
     * @return null|int
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmailActivation(): string {
        return $this->email_activation;
    }

    /**
     * @param string $email_activation
     */
    public function setEmailActivation(string $email_activation): void {
        $this->email_activation = $email_activation;
    }

    /**
     * @return null|string
     */
    public function getForgottenPassword(): ?string {
        return $this->forgotten_password;
    }

    /**
     * @param null|string $forgotten_password
     */
    public function setForgottenPassword(?string $forgotten_password): void {
        $this->forgotten_password = $forgotten_password;
    }

    /**
     * @return bool
     */
    public function isActivated(): bool {
        return !empty($this->getEmailActivation());
    }

    /**
     * @return string
     */
    public function getPassword(): string {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void {
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getPhone(): int {
        return $this->phone;
    }

    /**
     * @param int $phone
     */
    public function setPhone(int $phone): void {
        $this->phone = $phone;
    }
}
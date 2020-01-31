<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 28.
 * Time: 15:44
 */

namespace App\Service;


use App\Core\Validator;
use App\DAO\AddressDAOImpl;
use App\DAO\ConsumerDAOImpl;
use App\DAO\RestaurantDAOImpl;
use App\Model\Address;
use App\Model\Consumer;
use App\Model\Restaurant;
use App\Model\WhereClause;
use App\Settings;

class UserService {
    public function login($email, $password): bool {
        if ($email && $password) {
            $consumerDAO = ConsumerDAOImpl::getInstance();
            $consumer = $consumerDAO->findFirst(new WhereClause("email", "==", $email));
            if ($consumer) {
                $hash = $consumer->getPassword();
                if (password_verify($password, $hash)) {

                    return true;
                }
            } else {
                $restaurantDAO = RestaurantDAOImpl::getInstance();
                $restaurant = $restaurantDAO->findFirst(new WhereClause("email", "==", $email));
                if ($restaurant) {
                    $hash = $restaurant->getPassword();
                    if (password_verify($password, $hash)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function storeRestaurant(): ?array {
        $validator = new Validator(RequestService::getAll());
        $validator->check(array(
            'c_email' => array(
                'field_name' => 'e-mail cím',
                'required',
                'email',
                'unique#restaurant' => array(RestaurantDAOImpl::getInstance(), "email"),
                'unique#consumer' => array(ConsumerDAOImpl::getInstance(), "email")
            ),
            'c_cname' => array(
                'field_name' => 'étterem neve',
                'required',
                'unique' => array(RestaurantDAOImpl::getInstance(), "company_name"),
                'min' => 3,
                'max' => 64
            ),
            'c_password' => array(
                'field_name' => 'jelszó',
                'required',
                'min' => 6
            ),
            'c_password_again' => array(
                'field_name' => 'jelszó újra',
                'required',
                'matches' => 'c_password'
            ),
            'c_postcode' => array(
                'field_name' => 'irányítószám',
                'min' => 2,
                'max' => 16
            ),
            'c_city' => array(
                'field_name' => 'város',
                'min' => 2,
                'max' => 32
            ),
            'c_street' => array(
                'field_name' => 'utca',
                'min' => 2,
                'max' => 32
            ),
            'c_address' => array(
                'field_name' => 'házszám',
                'min' => 1,
                'max' => 32
            ),
            'c_phone' => array(
                'field_name' => 'telefonszám',
                'required',
                'has_digits',
                'min' => 4,
                'max' => 16
            ),
            'c_acceptterm' => array(
                'field_name' => 'adatvédelmi feltételek elfogadása',
                'checked'
            )
        ));
        if ($validator->passed()) {
            $email_code = $this->generateActivationCode();
            $restaurant = new Restaurant();
            $restaurant->setId(RestaurantDAOImpl::getInstance()->getAutoIncrementFieldValue("id"));
            $restaurant->setCompanyName(RequestService::fetch("c_cname"));
            $restaurant->setEmail(RequestService::fetch("c_email"));
            $restaurant->setEmailActivation($email_code);
            $restaurant->setPassword(password_hash(RequestService::fetch("c_password"), PASSWORD_DEFAULT));
            $restaurant->setPhone((int) preg_replace('/[^0-9]/', '', RequestService::fetch("c_phone")));
            $restaurant->setPostcode(RequestService::fetch("c_postcode"));
            $restaurant->setCity(RequestService::fetch("c_city"));
            $restaurant->setStreet(RequestService::fetch("c_street"));
            $restaurant->setAddress(RequestService::fetch("c_address"));
            RestaurantDAOImpl::getInstance()->create($restaurant);
            $mail = new EmailServiceImpl("noreply", RequestService::fetch("c_email"));
            $mail->addSubject("Fiók aktiválása");
            $mail->prepareContent("nemrég regisztrált oldalunkra.");
            $mail->addHeading("Tisztelt " . RequestService::fetch("c_cname") . "!");
            $mail->addText("Ön sikeresen regisztrált oldalunkra! A folyamat befejezéséhez kérjük kattintson az alább található gombra.");
            $mail->addButton(Settings::get('url') . "/activate?user=" . RequestService::fetch("c_email") . "&code=" . $email_code, Settings::get('url') . "/assets/img/activate.jpg");
            $mail->finishContent();
            $mail->send();
            SessionService::flash('login', 'Sikeresen regisztrált! Az aktiváló kódot elküldtük a megadott e-mail címre. Aktiválás nélkül nem tud belépni fiókjába.');
            return null;
        } else {
            return $validator->errors();
        }
    }

    public function storeConsumer(): ?array {
        $validator = new Validator(RequestService::getAll());
        $validator->check(array(
            'p_email' => array(
                'field_name' => 'e-mail cím',
                'required',
                'email',
                'unique#restaurant' => array(RestaurantDAOImpl::getInstance(), "email"),
                'unique#consumer' => array(ConsumerDAOImpl::getInstance(), "email")
            ),
            'p_lname' => array(
                'field_name' => 'vezetéknév',
                'required',
                'min' => 1,
                'max' => 32
            ),
            'p_fname' => array(
                'field_name' => 'keresztnév',
                'required',
                'min' => 1,
                'max' => 32
            ),
            'p_password' => array(
                'field_name' => 'jelszó',
                'required',
                'min' => 6
            ),
            'p_password_again' => array(
                'field_name' => 'jelszó újra',
                'required',
                'matches' => 'p_password'
            ),
            'p_postcode' => array(
                'field_name' => 'irányítószám',
                'min' => 2,
                'max' => 16
            ),
            'p_city' => array(
                'field_name' => 'város',
                'min' => 2,
                'max' => 32
            ),
            'p_street' => array(
                'field_name' => 'utca',
                'min' => 2,
                'max' => 32
            ),
            'p_address' => array(
                'field_name' => 'házszám',
                'min' => 1,
                'max' => 32
            ),
            'p_phone' => array(
                'field_name' => 'telefonszám',
                'required',
                'has_digits',
                'min' => 4,
                'max' => 16
            ),
            'p_byear' => array(
                'field_name' => 'születési év',
                'numeric' => true,
                'min' => 4,
                'max' => 4
            ),
            'p_bmonth' => array(
                'field_name' => 'születési hónap',
                'min' => 1,
                'max' => 2,
                'numeric' => true,
            ),
            'p_bday' => array(
                'field_name' => 'születési nap',
                'min' => 1,
                'max' => 2,
                'numeric' => true,
            ),
            'p_acceptterm' => array(
                'field_name' => 'adatvédelmi feltételek elfogadása',
                'checked'
            )
        ));
        if ($validator->passed()) {
            $email_code = $this->generateActivationCode();
            $consumer = new Consumer();
            $consumer->setId(ConsumerDAOImpl::getInstance()->getAutoIncrementFieldValue("id"));
            $consumer->setLastName(RequestService::fetch("p_lname"));
            $consumer->setFirstName(RequestService::fetch("p_fname"));
            $consumer->setEmail(RequestService::fetch("p_email"));
            $consumer->setEmailActivation($email_code);
            $consumer->setPassword(password_hash(RequestService::fetch("p_password"), PASSWORD_DEFAULT));
            $consumer->setPhone((int)preg_replace('/[^0-9]/', '', RequestService::fetch("p_phone")));
            $consumer->setBirthDay(RequestService::fetch("p_bday"));
            $consumer->setBirthMonth(RequestService::fetch("p_bmonth"));
            $consumer->setBirthYear(RequestService::fetch("p_byear"));
            ConsumerDAOImpl::getInstance()->create($consumer);
            $address = new Address();
            $address->setId(AddressDAOImpl::getInstance()->getAutoIncrementFieldValue("id"));
            $address->setConsumerId($consumer->getId());
            $address->setAlias("Otthon");
            $address->setPostcode(RequestService::fetch("p_postcode"));
            $address->setCity(RequestService::fetch("p_city"));
            $address->setStreet(RequestService::fetch("p_street"));
            $address->setAddress(RequestService::fetch("p_address"));
            AddressDAOImpl::getInstance()->create($address);
            $mail = new EmailServiceImpl("noreply", RequestService::fetch("p_email"));
            $mail->addSubject("Fiók aktiválása");
            $mail->prepareContent("nemrég regisztrált oldalunkra.");
            $mail->addHeading("Tisztelt " . RequestService::fetch("p_lname") . " " . RequestService::fetch("p_fname") . "!");
            $mail->addText("Ön sikeresen regisztrált oldalunkra! A folyamat befejezéséhez kérjük kattintson az alább található gombra.");
            $mail->addButton(Settings::get('url') . "/activate?user=" . RequestService::fetch("p_email") . "&code=" . $email_code, Settings::get('url') . "/assets/img/activate.jpg");
            $mail->finishContent();
            $mail->send();
            SessionService::flash('login', 'Sikeresen regisztrált! Az aktiváló kódot elküldtük a megadott e-mail címre. Aktiválás nélkül nem tud belépni fiókjába.');
            return null;
        } else {
            return $validator->errors();
        }
    }

    private function generateActivationCode($length = 16): string {
        $characterList = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $n = 0;
        $code = "";
        while ($n <= $length) {
            $code .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
            $n++;
        }
        return $code;
    }

}
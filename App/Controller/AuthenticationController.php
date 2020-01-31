<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 02.
 * Time: 14:07
 */

namespace App\Controller;


use App\Core\RoutR;
use App\Core\Validator;
use App\DAO\RestaurantDAO;
use App\DAO\RestaurantDAOImpl;
use App\Service\RequestService;
use App\Service\SessionService;
use App\Service\UserService;

class AuthenticationController extends Controller {
    public function authenticate() {
        $this->renderAsHTML();
        $this->setTemplateFile("login");
        $this->addData("message", SessionService::flash("login"));
    }
    public function login($email, $password, $rememberme) {
        $userService = new UserService();
        if ($userService->login($email, $password)) {
            if ($rememberme) {
                $userService->remember();
            }
            var_dump($_SESSION);
            RoutR::redirect("/");
        } else {
            $this->renderAsHTML();
            $this->setTemplateFile("login");
            $this->addData("errors", array("Hibás felhasználónév vagy jelszó!"));
        }
    }

    public function register() {
        $this->renderAsHTML();
        $this->setTemplateFile("register");
    }

    public function store($regtype) {
        $userService = new UserService();
        if($regtype) {
            //Restaurant
            $errors = $userService->storeRestaurant();
            if (empty($errors)) {
                RoutR::redirect("/bejelentkezes");
            } else {
                $this->renderAsHTML();
                $this->setTemplateFile("register");
                $this->addData("errors", $errors);
                $this->addData("is_company", true);
                $this->addData("c_email", RequestService::fetch("c_email"));
                $this->addData("c_cname", RequestService::fetch("c_cname"));
                $this->addData("c_phone", RequestService::fetch("c_phone"));
                $this->addData("c_postcode", RequestService::fetch("c_postcode"));
                $this->addData("c_city", RequestService::fetch("c_city"));
                $this->addData("c_street", RequestService::fetch("c_street"));
                $this->addData("c_address", RequestService::fetch("c_address"));
            }
        } else {
            //Consumer
            $errors = $userService->storeConsumer();
            if (empty($errors)) {
                RoutR::redirect("/bejelentkezes");
            } else {
                $this->renderAsHTML();
                $this->setTemplateFile("register");
                $this->addData("errors", $errors);
                $this->addData("is_company", false);
                $this->addData("p_email", RequestService::fetch("p_email"));
                $this->addData("p_lname", RequestService::fetch("p_lname"));
                $this->addData("p_fname", RequestService::fetch("p_fname"));
                $this->addData("p_postcode", RequestService::fetch("p_postcode"));
                $this->addData("p_city", RequestService::fetch("p_city"));
                $this->addData("p_street", RequestService::fetch("p_street"));
                $this->addData("p_address", RequestService::fetch("p_address"));
                $this->addData("p_phone", RequestService::fetch("p_phone"));
                $this->addData("p_bday", RequestService::fetch("p_bday"));
                $this->addData("p_bmonth", RequestService::fetch("p_bmonth"));
                $this->addData("p_byear", RequestService::fetch("p_byear"));
            }
        }
    }


}
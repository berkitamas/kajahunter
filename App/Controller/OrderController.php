<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 05.
 * Time: 16:39
 */

namespace App\Controller;


class OrderController extends Controller {

    public function list() {
        $this->renderAsHTML();
        $this->setTemplateFile("orders");
    }

}
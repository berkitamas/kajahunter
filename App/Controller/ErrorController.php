<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 01.
 * Time: 21:05
 */

namespace App\Controller;



class ErrorController extends Controller {
    public function error_404() {
        $this->renderAsHTML();
        $this->setTemplateFile("errors/404");
    }

}
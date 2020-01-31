<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 01.
 * Time: 18:33
 */

namespace App\Controller;


use App\Core\TemplateR;
use Exception;

abstract class Controller
{
    private $renderer;
    private $html;
    private $templateFile;
    private $data;


    public function __construct() {
        $this->renderer = new TemplateR();
        $this->html = false;
    }

    protected function setTemplateFile($templateFile) {
        $this->templateFile = $templateFile;
    }

    protected function renderAsHTML() {
      $this->html = true;
    }

    protected function addData($key, $value) {
        $this->data[$key] = $value;
    }

    public function render() {
        try {
            if($this->html) {
                $this->renderer->addTemplate("header");
                $this->renderer->addTemplate("nav");
                $this->renderer->addTemplate($this->templateFile);
                $this->renderer->addTemplate("footer");
            }
            $this->renderer->setData($this->data);
            $this->renderer->render();
        } catch (Exception $e) {
            echo "Error while loading the template: ";
            die($e->getMessage());
        }
    }
}
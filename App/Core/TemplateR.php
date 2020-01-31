<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 01.
 * Time: 13:03
 */

namespace App\Core;


use App\Core\Settings;
use App\Service\TokenService;
use function array_push;
use Exception;
use function extract;
use function file_exists;

class TemplateR
{
    private static $layoutPath = __DIR__ . "/../View/Layout/";

    private $templateFiles = array();
    private $data;

    /**
     * @param $template
     * @throws Exception
     */
    public function addTemplate($template) {
        if (file_exists(self::$layoutPath.$template.".template.php")) {
            array_push($this->templateFiles, self::$layoutPath.$template.".template.php");
        } else {
            throw new Exception("Template file " . self::$layoutPath.$template." not found!");
        }
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function render(): void {
        $token = TokenService::token(); //Shorthand

        if (isset($this->data)) {
            extract($this->data, EXTR_OVERWRITE);
        }

        foreach ($this->templateFiles as $templateFile) {
            require_once $templateFile;
        }
    }
}
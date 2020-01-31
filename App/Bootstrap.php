<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 01.
 * Time: 13:03
 */

namespace App;

use App\Core\RoutR;
use App\Service\SessionService;
use function session_start;

spl_autoload_register('\App\Bootstrap::autoload');

require_once "config/routes.php";
require_once "config/middlewares.php";
require_once "config/settings.php";

class Bootstrap
{
    public function init() {

        SessionService::init();

        $router = new RoutR();

        //Pretty URL
        $path = "";
        if(isset($_GET["path"])) {
            $path = $_GET["path"];
            unset($_GET["path"]);
        } else {
            $path = "/";
        }
        $router->requestPage($path, $_SERVER["REQUEST_METHOD"]);
    }

    //Resolve path from namespace (must be the same path as in namespace)
    public static function autoload($className)
    {
        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
        if ($lastNsPos = strripos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        require $fileName;
    }
}
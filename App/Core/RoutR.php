<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 01.
 * Time: 13:05
 */

namespace App\Core;

use App\Service\RequestService;
use App\Settings;
use function array_merge;
use function array_push;
use function explode;
use function http_response_code;
use function method_exists;
use function preg_match;
use ReflectionException;
use ReflectionMethod;
use function str_replace;
use function substr;

class RoutR
{
    private static $routes = array();
    private static $errorRoutes = array();
    private static $currentRoute;

    private $params;
    private $requestMethod;

    //Configuration handler part for config/routes.php

    public static function get(string $path, string $function) {
        return RoutR::addRoute($path, "GET", $function);
    }

    public static function post(string $path, string $function) {
        return RoutR::addRoute($path, "POST", $function);
    }

    public static function addRoute(string $path, string $requestMethod, string $function): RoutR {
        $path = trim($path, " \t\n\r\0\x0B/\\");

        $path = explode("/", $path);

        list($class, $method, $params) = self::parseFunction($function);

        self::addRouteToRoutes($path, $requestMethod, $class, $method, $params);

        return new self();
    }

    public static function middleware($string): RoutR {
        self::$currentRoute["middleware"][] = $string;
        return new self();
    }

    public static function error(int $errorCode, string $function) {
        list($class, $method, $params) = self::parseFunction($function);

        array_push(self::$errorRoutes, array(
            "error_code" => $errorCode,
            "class" => $class,
            "method" => $method,
            "params" => $params
        ));
    }

    private static function parseFunction(string $function): array {
        list($class, $method) = explode("@", $function);
        $method = str_replace(array(" ", ")"), "", $method);
        @list($method, $params) = explode("(", $method);
        if (!isset($params)) {
            $params = array();
        } else {
            $params = str_replace("$", "", $params);
            $params = explode(",", $params);
        }
        return array($class, $method, $params);
    }

    private static function addRouteToRoutes(array $path, string $requestMethod, string $class, string $method, array $params) {
        if(count($path) == 1 && $path[0] == "") {
            self::$currentRoute = [
                "class" => $class,
                "method" => $method,
                "params" => $params,
            ];
            self::$routes["methods"][$requestMethod] = &self::$currentRoute;
            return;
        }

        $currentPath = &self::$routes;

        foreach ($path as $pathElement) {
            if (preg_match("/\{[a-zA-Z_]{1}\w*\}/", $pathElement)) {
                settype($currentPath["dynamic"], "array");
                $currentPath = &$currentPath["dynamic"];
                $pathElement = substr($pathElement, 1, -1);
                $currentPath[0] = $pathElement;
            } else {
                settype($currentPath["static"], "array");
                $currentPath = &$currentPath["static"];
            }
            settype($currentPath[$pathElement], "array");
            $currentPath = &$currentPath[$pathElement];
        }

        $currentPath["methods"][$requestMethod] = [
            "class" => $class,
            "method" => $method,
            "params" => $params
        ];

    }

    //Request handler part

    public static function redirect($to) {
        if (substr($to, 0, 1) == '/') {
            header("Location: " . Settings::get("base") . "."  . $to);
        } else {
            header("Location: $to");
        }
        
    }

    public function addParam($key, $value) {
        $this->params[$key] = $value;
    }

    public function getParam($key) {
        return $this->params[$key];
    }

    public function getRequestMethod() {
        return $this->requestMethod;
    }

    public function requestPage(string $path, string $method) {
        $path = trim($path, " \t\n\r\0\x0B/\\");
        $path = explode("/", $path);

        $this->requestMethod = $method;

        if(count($path) == 1 && $path[0] == "") {
            if (isset(self::$routes["methods"][$method])) {
                $routes = &self::$routes;
                $middleware = new Middleware();
                $middleware->callMiddlewareChain(self::$routes["methods"][$method]["middleware"], $this, function (RoutR $router) use ($routes, $method) {
                    $router->callMethod($routes["methods"][$method]["class"], $routes["methods"][$method]["method"], $routes["methods"][$method]["params"]);
                });
            } else {
                $this->callErrorPage(400);
            }
            return;
        }

        $params = array();

        $currentPath = &self::$routes;

        foreach ($path as $pathElement) {

            if (isset($currentPath["static"][$pathElement])) {
                $currentPath = &$currentPath["static"][$pathElement];
            } elseif(isset($currentPath["dynamic"])) {
                $params[$currentPath["dynamic"][0]] = $pathElement;
                $currentPath = &$currentPath["dynamic"][$currentPath["dynamic"][0]];
            } else {
                $this->callErrorPage(404);
                return;
            }
        }

        if (!count($currentPath["methods"])) {
            $this->callErrorPage(404);
            return;
        }

        if(isset($currentPath["methods"][$method])) {
            $middleware = new Middleware();
            $middleware->callMiddlewareChain($currentPath["methods"][$method]["middleware"], $this, function (RoutR $router) use ($currentPath, $method, $params) {
                $router->callMethod($currentPath["methods"][$method]["class"], $currentPath["methods"][$method]["method"], $currentPath["methods"][$method]["params"], $params);
            });
        } else {
            $this->callErrorPage(400);
        }
    }

    public function callErrorPage(int $errorCode) {
        http_response_code($errorCode);

        $foundError = false;

        foreach (self::$errorRoutes as $route) {
            if ($route["error_code"] == $errorCode) {
                $foundError = true;
                $this->callMethod($route["class"], $route["method"], $route["params"]);
            }
        }

        if(!$foundError) {
            switch ($errorCode) {
                case 100:
                    $text = 'Continue';
                    break;
                case 101:
                    $text = 'Switching Protocols';
                    break;
                case 200:
                    $text = 'OK';
                    break;
                case 201:
                    $text = 'Created';
                    break;
                case 202:
                    $text = 'Accepted';
                    break;
                case 203:
                    $text = 'Non-Authoritative Information';
                    break;
                case 204:
                    $text = 'No Content';
                    break;
                case 205:
                    $text = 'Reset Content';
                    break;
                case 206:
                    $text = 'Partial Content';
                    break;
                case 300:
                    $text = 'Multiple Choices';
                    break;
                case 301:
                    $text = 'Moved Permanently';
                    break;
                case 302:
                    $text = 'Moved Temporarily';
                    break;
                case 303:
                    $text = 'See Other';
                    break;
                case 304:
                    $text = 'Not Modified';
                    break;
                case 305:
                    $text = 'Use Proxy';
                    break;
                case 400:
                    $text = 'Bad Request';
                    break;
                case 401:
                    $text = 'Unauthorized';
                    break;
                case 402:
                    $text = 'Payment Required';
                    break;
                case 403:
                    $text = 'Forbidden';
                    break;
                case 404:
                    $text = 'Not Found';
                    break;
                case 405:
                    $text = 'Method Not Allowed';
                    break;
                case 406:
                    $text = 'Not Acceptable';
                    break;
                case 407:
                    $text = 'Proxy Authentication Required';
                    break;
                case 408:
                    $text = 'Request Time-out';
                    break;
                case 409:
                    $text = 'Conflict';
                    break;
                case 410:
                    $text = 'Gone';
                    break;
                case 411:
                    $text = 'Length Required';
                    break;
                case 412:
                    $text = 'Precondition Failed';
                    break;
                case 413:
                    $text = 'Request Entity Too Large';
                    break;
                case 414:
                    $text = 'Request-URI Too Large';
                    break;
                case 415:
                    $text = 'Unsupported Media Type';
                    break;
                case 500:
                    $text = 'Internal Server Error';
                    break;
                case 501:
                    $text = 'Not Implemented';
                    break;
                case 502:
                    $text = 'Bad Gateway';
                    break;
                case 503:
                    $text = 'Service Unavailable';
                    break;
                case 504:
                    $text = 'Gateway Time-out';
                    break;
                case 505:
                    $text = 'HTTP Version not supported';
                    break;
                default:
                    exit('Unknown http status code "' . htmlentities($errorCode) . '"');
                    break;
            }
            echo "Error $errorCode: $text";
        }
    }

    private function callMethod(string $class, string $method, array $requestParams, array $dynamicParams = null) {
        $class = "\App\Controller\\" . $class;
        foreach ($requestParams as $param) {
            if (RequestService::exists($param)) {
                $this->params[$param] = RequestService::fetch($param);
            }
        }

        if ($dynamicParams) {
            $this->params = array_merge($this->params, $dynamicParams);
        }

        try {
            $reflection = new ReflectionMethod($class, $method);
        } catch (ReflectionException $e) {
            die("Error while calling method: " . $e->getMessage());
        }

        $sorted_params = array();

        foreach ($reflection->getParameters() as $parameter) {
            $sorted_params[] = $this->params[$parameter->name];
        }

        $params = $sorted_params;

        $object = new $class();
        call_user_func_array(array($object, $method), $params);
        if (method_exists($object, "render")) {
            $object->render();
        }
    }

}
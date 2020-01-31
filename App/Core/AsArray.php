<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 30.
 * Time: 2:57
 */

namespace App\Core;


use ReflectionProperty;

abstract class AsArray implements IAsArray {
    protected $asArray = [];

    public function __construct() {
        try {
            $clazz = new \ReflectionClass($this);
        } catch (\ReflectionException $e) {
            die("Error while accessing property: " . $e->getMessage());
        }
        $props = [];
        $props = array_merge($props, $clazz->getProperties(ReflectionProperty::IS_PROTECTED));
        $props = array_merge($props, $clazz->getProperties(ReflectionProperty::IS_PRIVATE));
        $props = array_merge($props, $clazz->getProperties(ReflectionProperty::IS_PUBLIC));
        $props = array_merge($props, $clazz->getProperties(ReflectionProperty::IS_STATIC));
        foreach ($props as $prop) {
            $comments = $prop->getDocComment();
            preg_match_all("/\s*\*\s*\@(G|g)(E|e)(T|t)\s*(?<function>\w+)/", $comments, $parsed_get);
            $parsed_get = $parsed_get["function"][0];
            preg_match_all("/\s*\*\s*\@(S|s)(E|e)(T|t)\s*(?<function>\w+)/", $comments, $parsed_set);
            $parsed_set = $parsed_set["function"][0];
            if ($parsed_get) {
                if (method_exists($this, $parsed_get)) {
                    $this->asArray[$prop->getName()]["get"] = $parsed_get;
                }
            }
            if ($parsed_set) {
                if (method_exists($this, $parsed_set)) {
                    $this->asArray[$prop->getName()]["set"] = $parsed_set;
                }
            }
        }
    }

    public function fromArray(array $fields) {
        foreach ($fields as $field => $value) {
            if (isset($this->asArray[$field]["set"])) {
                call_user_func(array($this, $this->asArray[$field]["set"]), $value);
            }
        }
        return $this;
    }

    public function toArray(): array {
        $retVal = [];
        foreach ($this->asArray as $field => $methods) {
            if (isset($methods["get"])) {
                $retVal[$field] = call_user_func(array($this, $methods["get"]));
            }
        }
        return $retVal;
    }

    public function toEscapedArray(): array {
        $retVal = [];
        foreach ($this->asArray as $field => $methods) {
            if (isset($methods["get"])) {
                $retVal[$field] = call_user_func(array($this, $methods["get"]));
                if (is_string($retVal[$field])) {
                    $retVal[$field] = htmlspecialchars($retVal[$field]);
                }
            }
        }
        return $retVal;
    }

    public function offsetSet($offset, $value) {
        foreach ($this->asArray as $field => $methods) {
            if ($field == $offset) {
                if (isset($methods["set"])) {
                    call_user_func(array($this, $methods["set"]), $value);
                }
            }
        }
    }

    public function offsetGet($offset) {
        foreach ($this->asArray as $field => $methods) {
            if ($field == $offset) {
                if (isset($methods["get"])) {
                    return call_user_func(array($this, $methods["get"]));
                }
            }
        }
    }

    public function offsetExists($offset) {
        foreach ($this->asArray as $field => $methods) {
            if ($field == $offset) {
                if (isset($methods["get"])) {
                    return is_null(call_user_func(array($this, $methods["get"])));
                }
            }
        }
        return false;
    }

    public function offsetUnset($offset) {
        foreach ($this->asArray as $field => $methods) {
            if ($field == $offset) {
                if (isset($methods["set"])) {
                    call_user_func(array($this, $methods["set"]), null);
                }
            }
        }
    }

    public function getFieldsWithSetter(): array {
        //print only properties with setter
        $fields = [];
        foreach ($this->asArray as $field => $method) {
            if (!empty($method["set"])) {
                $fields[] = $field;
            }
        }
        return $fields;
    }

}
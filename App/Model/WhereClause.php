<?php
/**
 * Created by PhpStorm.
 * User: thomastopies
 * Date: 2018. 03. 26.
 * Time: 21:41
 */

namespace App\Model;


class WhereClause {
    private $mode;
    private $elements;
    private $operators;

    public function __construct($field = null, $op = "==", $matching = null, $mode = "or") {
        $this->setOperators();
        $this->mode = $mode;
        $this->elements = [];
        if ($field && in_array($op, $this->getOperators())) {
            array_push($this->elements, [
                "field" => $field,
                "matching" => $matching,
                "mode" => $op
            ]);
        }
    }

    public function addElement($field, $op, $matching) {
        if (in_array($op, $this->getOperators())) {
            array_push($this->elements, [
                "field" => $field,
                "matching" => $matching,
                "mode" => $op
            ]);
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    public function getOperators(): array {
        return array_keys($this->operators);
    }

    public function match($fields): bool {
        if (!count($this->elements)) {
            return true;
        }
        $retval = false;
        foreach ($fields as $field => $value) {
            foreach ($this->elements as $element) {
                if ($element["field"] == $field) {
                    if ($this->operators[$element["mode"]]($value, $element["matching"])) {
                        $retval = true;
                    } else {
                        if ($this->mode == "and") {
                            return false;
                        }
                    }
                }
            }
        }
        return $retval;
    }

    private function setOperators(): void {
        $this->operators = array(
            "==" => function ($a, $b) {
                return ($a == $b);
            },
            "!=" => function ($a, $b) {
                return ($a != $b);
            },
            ">" => function ($a, $b) {
                return ($a > $b);
            },
            "<" => function ($a, $b) {
                return ($a < $b);
            },
            "<=" => function ($a, $b) {
                return ($a <= $b);
            },
            ">=" => function ($a, $b) {
                return ($a >= $b);
            },
            "LIKE" => function ($a, $b) {
                return (is_string($a) && is_string($b) && strpos($a, $b) !== false);
            }
        );
    }

    /**
     * @return array
     */
    public function getElements(): array {
        return $this->elements;
    }
}
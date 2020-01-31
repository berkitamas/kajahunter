<?php
/**
 * Created by PhpStorm.
 * User: thomastopies
 * Date: 2018. 03. 26.
 * Time: 21:41
 */

namespace App\Model;


class OrderByClause {
    private $elements;

    public function __construct($field = null, $mode = "ASC") {
        $this->elements = [];
        if ($field && ($mode == "ASC" || $mode == "DESC")) {
            array_push($this->elements, [
                "field" => $field,
                "mode" => ($mode == "ASC")?SORT_ASC:SORT_DESC
            ]);
        }
    }

    public function addElement($field, $mode = "ASC") {
        if (($mode == "ASC" || $mode == "DESC")) {
            array_push($this->elements, [
                "field" => $field,
                "mode" => ($mode == "ASC")?SORT_ASC:SORT_DESC
            ]);
        } else {
            return false;
        }
    }

    public function order(&$fields): void {
        $to_array = [];
        foreach ($fields as $field) {
            $to_array[] = $field->toArray();
        }
        $params = [];
        foreach ($this->elements as $element) {
            $params[] = array_column($to_array, $element["field"]);
            $params[] = $element["mode"];
        }
        $params[] = &$fields;
        call_user_func_array("array_multisort", $params);
    }

    /**
     * @return array
     */
    public function getElements(): array {
        return $this->elements;
    }
}
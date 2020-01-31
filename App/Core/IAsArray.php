<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 30.
 * Time: 16:42
 */

namespace App\Core;


interface IAsArray extends \ArrayAccess {
    public function fromArray(array $fields);
    public function toArray(): array;
    public function getFieldsWithSetter(): array;
}
<?php
/**
 * Created by PhpStorm.
 * User: thomastopies
 * Date: 2018. 03. 26.
 * Time: 21:34
 */

namespace App\DAO;

use App\Core\Singleton;
use App\Model\CommonModel;
use App\Model\Item;
use Exception;

class ItemDAOImpl extends FileDAO implements ItemDAO {
    use Singleton;

    protected function init() {
        try {
            $this->loadFile("items")->autoIncrement("id");
        } catch (Exception $e) {
            die("Error during database load: " . $e->getMessage());
        }
    }

    protected static function createObjectFromArray(array $fields): ?CommonModel {
        $item = new Item();
        return $item->fromArray($fields);
    }

    protected static function getSchema(): array {
        $item = new Item();
        return $item->getFieldsWithSetter();
    }


}
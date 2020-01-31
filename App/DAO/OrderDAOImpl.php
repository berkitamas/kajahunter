<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 27.
 * Time: 15:34
 */

namespace App\DAO;


use App\Core\Singleton;
use App\Model\CommonModel;
use App\Model\Order;
use Exception;

class OrderDAOImpl extends FileDAO implements CommonDAO {
    use Singleton;

    protected function init() {
        try {
            $this->loadFile("orders")->autoIncrement("id");
        } catch (Exception $e) {
            die("Error during database load: " . $e->getMessage());
        }
    }

    protected static function createObjectFromArray(array $fields): ?CommonModel {
        $order = new Order();
        return $order->fromArray($fields);
    }

    protected static function getSchema(): array {
        $order = new Order();
        return $order->getFieldsWithSetter();
    }


}
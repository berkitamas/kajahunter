<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 26.
 * Time: 23:06
 */

namespace App\DAO;

use App\Core\Singleton;
use App\Model\CommonModel;
use App\Model\Restaurant;
use Exception;

class RestaurantDAOImpl extends FileDAO implements RestaurantDAO {
    use Singleton;

    protected function init() {
        try {
            $this->loadFile("restaurants")->autoIncrement("id");
        } catch (Exception $e) {
            die("Error during database load: " . $e->getMessage());
        }
    }

    protected static function createObjectFromArray(array $fields): ?CommonModel {
        $restaurant = new Restaurant();
        return $restaurant->fromArray($fields);
    }

    protected static function getSchema(): array {
        $restaurant = new Restaurant();
        return $restaurant->getFieldsWithSetter();
    }


}
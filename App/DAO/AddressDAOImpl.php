<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 26.
 * Time: 23:09
 */

namespace App\DAO;


use App\Core\Singleton;
use App\Model\Address;
use App\Model\CommonModel;
use Exception;
use function Sodium\add;

class AddressDAOImpl extends FileDAO implements AddressDAO {
    use Singleton;

    protected function init() {
        try {
            $this->loadFile("addresses")->autoIncrement("id");
        } catch (Exception $e) {
            die("Error during database load: " . $e->getMessage());
        }
    }

    protected static function createObjectFromArray(array $fields): ?CommonModel {
        $address = new Address();
        return $address->fromArray($fields);
    }

    protected static function getSchema(): array {
        $address = new Address();
        return $address->getFieldsWithSetter();
    }
}
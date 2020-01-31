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
use App\Model\Consumer;
use Exception;

class ConsumerDAOImpl extends FileDAO implements ConsumerDAO {
    use Singleton;

    protected function init() {
        try {
            $this->loadFile("consumers")->autoIncrement("id");
        } catch (Exception $e) {
            die("Error during database load: " . $e->getMessage());
        }
    }

    protected static function createObjectFromArray(array $fields): ?CommonModel {
        $consumer = new Consumer();
        return $consumer->fromArray($fields);
    }

    protected static function getSchema(): array {
        $consumer = new Consumer();
        return $consumer->getFieldsWithSetter();
    }
}
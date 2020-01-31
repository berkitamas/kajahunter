<?php
/**
 * Created by PhpStorm.
 * User: thomastopies
 * Date: 2018. 03. 26.
 * Time: 21:34
 */

namespace App\DAO;

use App\Core\Singleton;
use App\Model\Category;
use App\Model\CommonModel;
use Exception;

class CategoryDAOImpl extends FileDAO implements CategoryDAO {
    use Singleton;

    protected function init() {
        try {
            $this->loadFile("categories")->autoIncrement("id");
        } catch (Exception $e) {
            die("Error during database load: " . $e->getMessage());
        }
    }

    protected static function createObjectFromArray(array $fields): ?CommonModel {
        $category = new Category();
        return $category->fromArray($fields);
    }

    protected static function getSchema(): array {
        $category = new Category();
        return $category->getFieldsWithSetter();
    }
}
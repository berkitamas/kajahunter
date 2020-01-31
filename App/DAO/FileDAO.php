<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 27.
 * Time: 13:35
 */

namespace App\DAO;


use App\Model\CommonModel;
use App\Model\OrderByClause;
use App\Model\WhereClause;
use Exception;

abstract class FileDAO implements CommonDAO {

    /**
     * @var string
     */
    protected $file_name;

    /**
     * @var CommonModel[]
     */
    protected $data;

    /**
     * @var int[]
     */
    protected $auto_increment;

    /**
     * @return string
     */
    public function getFileName(): string {
        return $this->file_name;
    }

    /**
     * @param string $file_name
     */
    public function setFileName(string $file_name): void {
        $this->file_name = $file_name;
    }

    /**
     * @param string $field
     * @return FileDAO
     * @throws Exception
     */
    public function autoIncrement(string $field) {
        $this->auto_increment[$field] = 0;
        foreach ($this->data as $data) {
            $fields = $data->getFieldsWithSetter();
            if (!in_array($field, $fields)) {
                throw new Exception("Auto incremented field not found");
            }

            if ($data[$field] > $this->auto_increment[$field]) {
                $this->auto_increment[$field] = $data[$field];
            }
        }
        return $this;
    }

    /**
     * @param string $field
     * @return int
     */
    public function getAutoIncrementFieldValue(string $field): int {
        return ++$this->auto_increment[$field];
    }

    /**
     * @param string $file
     * @return FileDAO
     * @throws Exception
     */
    protected function loadFile(string $file): FileDAO {
        $this->setFileName($file);
        $this->data = [];
        if (file_exists(__DIR__ . "/../../db/" . $this->file_name . ".csv")) {
            $file = fopen(__DIR__ . "/../../db/" . $this->file_name . ".csv", "r");
            $schema = fgetcsv($file);
            if(is_array($schema) && !empty(array_diff($schema, $this->getSchema()))) {
                // File has fields which schema don't
                // We treat it as fatal, because it can lead to serious data loss
                throw new Exception("Database has unknown fields");
            }
            while (!feof($file)) {
                $parsed = fgetcsv($file);
                if (!empty($parsed)) {
                    if (!($row = array_combine($schema, $parsed))) {
                        throw new Exception("Data integrity violation");
                    }
                    //Convert every empty element to null
                    //Necessary for nullable type hints
                    foreach ($row as $field => $value) {
                        if (empty($value)) {
                            $row[$field] = null;
                        }
                    }
                    $object = $this->createObjectFromArray($row);
                    $this->data[] = $object;
                }
            }
            fclose($file);
        } else {
            $file = fopen(__DIR__ . "/../../db/" . $this->file_name . ".csv", "w");
            fputcsv($file, $this->getSchema());
            fclose($file);
        }
        return $this;
    }

    abstract protected static function createObjectFromArray(array $fields): ?CommonModel;

    abstract protected static function getSchema(): array;

    public function create(CommonModel $elem): CommonModel {
        array_push($this->data, $elem);
        $this->updateFile();
        return $elem;
    }

    public function update(int $id, CommonModel $elem): CommonModel {
        $elem->setId($id);
        $this->data[$id] = $elem;
        $this->updateFile();
        return $elem;
    }

    public function delete(int $id): void {
        unset($this->data[$id]);
        $this->updateFile();
    }

    public function get(int $id): ?CommonModel {
        return $this->findFirst(new WhereClause("id", "==", $id), null);
    }

    public function find(WhereClause $where, OrderByClause $order = null, $limit = 0, $offset = 0): array {
        $matches = [];
        foreach ($this->data as $data) {
            if ($where->match($data->toArray())) {
                array_push($matches, $data);
            }
        }

        if ($order) {
            $order->order($matches);
        }

        if ($limit > 0) {
            $matches = array_slice($matches, $offset, $limit);
        }

        return $matches;
    }

    public function findFirst(WhereClause $where, OrderByClause $order = null): ?CommonModel {
        return $this->find($where, $order, 1, 0)[0];
    }

    public function list(OrderByClause $order = null, $limit = 0, $offset = 0): array {
        return $this->find(new WhereClause(), $order, $limit, $offset);
    }

    public function count(WhereClause $where = null): int {
        if ($where) {
            return count($this->find($where));
        } else {
            return count($this->data);
        }
    }

    public function has(WhereClause $where = null): bool {
        return ($this->count($where) > 0);
    }

    private function updateFile(): void {
        $file = fopen(__DIR__ . "/../../db/" . $this->file_name . ".csv", "w");
        fputcsv($file, $this->getSchema());
        foreach ($this->data as $data) {
            //Order by specified schema
            $schema = array_flip($this->getSchema());
            fputcsv($file, array_replace($schema, array_intersect_key($data->toArray(), $schema)));
        }
        fclose($file);
    }
}
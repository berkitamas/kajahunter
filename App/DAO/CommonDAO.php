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

interface CommonDAO {
    public function create(CommonModel $category): CommonModel;
    public function update(int $id, CommonModel $category): CommonModel;
    public function delete(int $id): void;
    public function get(int $id): ?CommonModel;
    public function count(): int;
    public function find(WhereClause $where, OrderByClause $order = null, $limit = 0, $offset = 0): array;
    public function findFirst(WhereClause $where, OrderByClause $order = null): ?CommonModel;
    public function list(OrderByClause $order = null, $limit = 0, $offset = 0): array;
    public function has(WhereClause $where): bool;
}
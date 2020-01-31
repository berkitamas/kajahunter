<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 28.
 * Time: 1:31
 */

namespace App\Service;


use App\DAO\OrderDAOImpl;
use App\DAO\RestaurantDAOImpl;
use App\Model\OrderByClause;

class RestaurantService {
    private $dao;

    public function __construct() {
        $this->dao = RestaurantDAOImpl::getInstance();
    }

    public function getPopularRestaurants(): array {
        $order_dao = OrderDAOImpl::getInstance();
        $orders_grouped = [];
        $orders = $order_dao->list();
        foreach ($orders as $order) {
            if (!isset($orders_grouped[$order->getRestaurantId()])) {
                $orders_grouped[$order->getRestaurantId()] = 0;
            }
            $orders_grouped[$order->getRestaurantId()]++;
        }
        arsort($orders_grouped);
        $orders_grouped = array_slice($orders_grouped, 0, 6, true);
        $restaurants = [];
        foreach ($orders_grouped as $id => $value) {
            //Is restaurant deleted?
            $restaurant = $this->dao->get($id);
            if ($restaurant) {
                //if not, we add it to array
                $restaurants[] = $restaurant;
            }
        }
        return $restaurants;
    }

    public function listRestaurantsByName(): array {
        return $this->dao->list(new OrderByClause("company_name"));
    }


}
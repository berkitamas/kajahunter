<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 04.
 * Time: 11:46
 */

namespace App\Controller;


use App\Service\DateService;
use App\Service\RestaurantService;
use function var_dump;

class RestaurantController extends Controller {
    public function list() {
        $this->renderAsHTML();
        $this->setTemplateFile("restaurants");
        $restaurantService = new RestaurantService();
        $dateService = new DateService();
        $restaurants = [];
        foreach ($restaurantService->listRestaurantsByName() as $restaurant) {
            $arr_restaurant = $restaurant->toArray();
            //XSS Protection
            foreach ($arr_restaurant as $key => $field) {
                if (is_string($field)) {
                    $arr_restaurant[$key] = htmlspecialchars($field);
                }
            }
            $arr_restaurant["nonstop"] = $restaurant->isNonStop();
            if (!$arr_restaurant["nonstop"]) {
                $arr_restaurant["parsed_from"] = $dateService->getFormattedTimeFromMinute($arr_restaurant["open_from"]);
                $arr_restaurant["parsed_to"] = $dateService->getFormattedTimeFromMinute($arr_restaurant["open_to"]);
                $arr_restaurant["opened"] = $dateService->isCurrentTimeInInterval($arr_restaurant["open_from"], $arr_restaurant["open_to"]);
            }
            $restaurants[] = $arr_restaurant;
        }
        $this->addData("restaurants", $restaurants);
    }

    public function restaurantDetails($id) {
        $this->renderAsHTML();
        $this->setTemplateFile("restaurantDetails");
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 01.
 * Time: 18:32
 */

namespace App\Controller;

use App\Model\Address;
use App\Model\Restaurant;
use App\Service\DateService;
use App\Service\RestaurantService;

class RootController extends Controller
{
    public function index() {
        $this->renderAsHTML();
        $this->setTemplateFile("landing");
        $restaurantService = new RestaurantService();
        $this->addData("part_of_day", DateService::getCurrentPartOfDay());
        $restaurants = [];
        foreach ($restaurantService->getPopularRestaurants() as $restaurant) {
            $arr_restaurant = $restaurant->toEscapedArray();
            $arr_restaurant["nonstop"] = $restaurant->isNonStop();
            if (!$arr_restaurant["nonstop"]) {
                $arr_restaurant["parsed_from"] = DateService::getFormattedTimeFromMinute($arr_restaurant["open_from"]);
                $arr_restaurant["parsed_to"] = DateService::getFormattedTimeFromMinute($arr_restaurant["open_to"]);
            }
            $restaurants[] = $arr_restaurant;
        }
        $this->addData("restaurants", $restaurants);
    }
}
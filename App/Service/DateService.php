<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 28.
 * Time: 12:30
 */

namespace App\Service;


class DateService {
     public static function getCurrentPartOfDay(): int {
         $hour = (int) date("H");
         if ($hour >= 16) {
             return 2;
         } elseif ($hour >= 11) {
             return 1;
         } else {
             return 0;
         }
     }

     public static function getFormattedTimeFromMinute(int $minute): string {
         $hour = 0;
         while ($minute >= 60) {
             $minute -= 60;
             $hour++;
         }
         return sprintf("%02d:%02d", $hour, $minute);
     }

     public static function isCurrentTimeInInterval($start, $end) {
         $minute = (int) date("i");
         $minute += ((int) date("H")) * 60;
         return ($minute >= $start && $minute < $end);
     }

     public static function getCurrentTimestamp(): int {
         $date = new \DateTime();
         return $date->getTimestamp();
     }
}
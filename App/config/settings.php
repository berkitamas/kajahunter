<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 30.
 * Time: 21:30
 */

use App\Settings;

Settings::set("base", "/kajahunter/");
Settings::set("url", "http://edu.btj.hu" . Settings::get("base"));
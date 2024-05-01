<?php

namespace App\Core\Helpers;

class Validation {

    public static function isEmpty($array) {
        $is_empty = array_filter($array, function ($data) {
            return empty($data);
        });        

        return !boolval($is_empty);
    }

}


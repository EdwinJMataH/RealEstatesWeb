<?php

namespace App\Core\Helpers;

use App\Exceptions\ErrorException;

class Validation {

    public static function failedValidation($validator) {
        if ($validator->stopOnFirstFailure()->fails()) {
            throw new ErrorException(['message' => ucfirst($validator->errors()->first())]);
        }
    }

    public static function isEmpty($array) {
        $is_empty = array_filter($array, function ($data) {
            return empty($data);
        });

        return !boolval($is_empty);
    }

}


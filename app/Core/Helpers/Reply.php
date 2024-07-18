<?php

namespace App\Core\Helpers;

class Reply {

    public static function getResponse(string $slug, $data = []) {
        return (object)[
            'status'  => true,
            'slug'    => $slug,
            'message' => __('messages.'.$slug),
            'data'    => (object)$data
        ];
    }

}


<?php

namespace App\Core\Helpers;
use App\Repositories\ErrorMessagesRepository;

class Reply {

    public static function getResponse(string $slug, $data = []) {
        return (object)[
            'status'  => true,
            'slug'    => $slug,
            'message' => ErrorMessagesRepository::getMessage($slug),
            'data'    => $data
        ];
    }

}


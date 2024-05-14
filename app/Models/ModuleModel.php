<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class ModuleModel  {

    private static $table = 'modules';

    public static function index(){
        $response = (object)[
            'status' => false,
        ];
        $columns = [
            'module_id',
        ];

        try {
            $data = DB::table(self::$table)->select($columns)->get();

            $response->status = true;
            $response->data   = $data;
            return $response;

        } catch (\PDOException $e) {
            $response->error = $e->getMessage();
            return $response;
        }

    }

}

<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class UserModel  {

    private static $table = 'users';

    public static function index(){
        $response = (object)[
            'status' => false,
        ];
        $columns = [
            'uuid AS id',
            'name',
            'email',
            'permission',
            'profile',
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

    public static function create($request){
        $response = (object)[
            'status' => false,
        ];
        try {
            DB::beginTransaction();

            $is_save = DB::table(self::$table)->insertGetId($request->columns);

            DB::commit();    

            $response->status = true;
            $response->data   = $is_save;
            return $response;

        } catch (\PDOException $e) {
            $response->error = $e->getMessage();
            DB::rollBack();
            return $response;
        }

    }
    
}

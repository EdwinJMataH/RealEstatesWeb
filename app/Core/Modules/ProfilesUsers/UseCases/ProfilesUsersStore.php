<?php
namespace App\Core\Modules\ProfilesUsers\UseCases;
use App\Repositories\ErrorMessagesRepository;
use App\Models\ProfilesUsersModel;

class ProfilesUsersStore {
    public static function store($request)
    {
        return $request->is('mi-ruta');
        // if ($request->routeIs('mi-ruta-nombre')) {
        //     # code...
        // }
    }
            // try {

        //     return $errorMessage = ErrorMessagesRepository::getMessage('1001');

        //     // throw new \Exception("Error Processing Request", 1);
            
        //     return response()->json(['message' => $errorMessage], 200);
        // } catch (\Exception $e) {
        //     // Si ocurre un error durante el procesamiento de la solicitud, devuelve una respuesta de error
        //     return response()->json(['message' => $e->getMessage()]);
        // }
}
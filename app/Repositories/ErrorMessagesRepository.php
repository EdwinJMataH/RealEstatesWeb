<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Config;

class ErrorMessagesRepository {
    public static function getMessage($code)
    {
        // Obtiene el mensaje de error correspondiente al código proporcionado desde el archivo de configuración
        return Config::get("errors.messages." . $code, "Se ha producido un error desconocido. Por favor, contacta al administrador del sistema.");
    }
}
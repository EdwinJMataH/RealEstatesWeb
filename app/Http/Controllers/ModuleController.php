<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Core\Modules\Module\UseCases\ModuleIndex;

class ModuleController extends Controller {

    public function index() {
        $response = ModuleIndex::index();
        return response()->json($response);
    }

}

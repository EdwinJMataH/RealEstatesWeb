<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Core\Modules\User\UseCases\UserStore;
use App\Core\Modules\User\UseCases\UserIndex;

class UserController extends Controller {

    public function all() {
        $response = UserIndex::index();
        return response()->json($response);
    }

    public function index() {
        return Inertia::render('User');
    }

    public function store(Request $request) {
        $response = UserStore::store($request);
        return response()->json($response);
    }

}

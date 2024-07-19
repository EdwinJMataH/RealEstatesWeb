<?php

namespace App\Http\Controllers;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Core\Modules\User\UseCases\UserAll;
use App\Http\Requests\UserValidatorRequest;
use App\Core\Modules\User\UseCases\UserStore;
use App\Core\Modules\User\UseCases\UserUpdate;
use App\Core\Modules\User\UseCases\UserDestroy;

class UserController extends Controller {

    public function all() {
        $response = UserAll::index();
        return response()->json($response);
    }

    public function index() {
        return Inertia::render('User/Index');
    }

    public function store(UserValidatorRequest $request) {
        $response = UserStore::store($request);
        return response()->json($response);
    }

    public function update(UserValidatorRequest $request, $uuid) {
        $request->uuid = $uuid;
        $response = UserUpdate::store($request);
        return response()->json($response);
    }

    public function destroy(Request $request, $uuid) {
        $request->uuid = $uuid;
        $response = UserDestroy::store($request);
        return response()->json($response);
    }

}

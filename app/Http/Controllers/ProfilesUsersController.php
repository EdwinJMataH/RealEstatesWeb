<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

class ProfilesUsersController extends Controller
{
    public function index() {
        return Inertia::render('ProfilesUsers');
    }

}

<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Requests\User\PasswordRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Requests\User\ProfileUpdateRequest;
use App\Core\Modules\Profile\UseCases\ProfileUpdateImage;
use App\Core\Modules\Profile\UseCases\ProfileUpdatePassword;
use App\Core\Modules\Profile\UseCases\ProfileUpdateInformation;
use App\Core\Modules\Profile\UseCases\ProfileShowInformation;

class ProfileController extends Controller
{
    public function index() {
        return Inertia::render('Profile/Index');
    }

    public function password(PasswordRequest $request) {
        $response = ProfileUpdatePassword::update($request);
        return response()->json($response);
    }

    public function update(ProfileUpdateRequest $request) {
        $response = ProfileUpdateInformation::update($request);
        return response()->json($response);

    }

    public function image(Request $request) {
        $response = ProfileUpdateImage::update($request);
        return response()->json($response);
    }

    public function show(Request $request) {
        $response = ProfileShowInformation::index($request);
        return response()->json($response);
    }



    /**
     * Display the user's profile form.
     */
    // public function edit(Request $request): Response
    // {
    //     return Inertia::render('Profile/Edit', [
    //         'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
    //         'status' => session('status'),
    //     ]);
    // }

    /**
     * Update the user's profile information.
     */
    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('profile.edit');
    // }

    /**
     * Delete the user's account.
     */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'password' => ['required', 'current-password'],
    //     ]);

    //     $user = $request->user();

    //     Auth::logout();

    //     $user->delete();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return Redirect::to('/');
    // }
}

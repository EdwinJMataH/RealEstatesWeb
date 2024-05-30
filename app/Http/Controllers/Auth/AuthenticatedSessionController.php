<?php

namespace App\Http\Controllers\Auth;

use Throwable;
use Inertia\Inertia;
use Inertia\Response;
use App\Core\Helpers\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Sleep;
use App\Exceptions\ErrorException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $slug = 'login-success';
        try {

            $request->authenticate();

            $request->session()->regenerate();

            return Reply::getResponse($slug);

        } catch (ErrorException $e) {
            return $e->getResponse();
        } catch (Throwable $e) {
            throw new ErrorException(['message' => $e->getMessage()]);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        $slug = 'logout-success';
        try {

            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return Reply::getResponse($slug);
        } catch (ErrorException $e) {
            return $e->getResponse();
        } catch (Throwable $e) {
            throw new ErrorException(['message' => $e->getMessage()]);
        }
    }
}

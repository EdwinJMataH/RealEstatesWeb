<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Throwable;
use Inertia\Inertia;
use Inertia\Response;
use App\Core\Helpers\Reply;
use Illuminate\Http\Request;
use App\Exceptions\ErrorException;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        try {

            $request->validate(['email' => 'required|email']);

            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status != 'passwords.sent') throw new Exception(__($status));

            return Reply::getResponse('passwords-sent');
        } catch (ErrorException $e) {
            return $e->getResponse();
        } catch (Throwable $e) {
            throw new ErrorException(['message' => $e->getMessage()]);
        }
    }
}

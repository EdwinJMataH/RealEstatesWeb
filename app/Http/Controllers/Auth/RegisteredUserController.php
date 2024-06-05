<?php

namespace App\Http\Controllers\Auth;

use Throwable;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Core\Helpers\Reply;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Exceptions\ErrorException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $slug = 'register-success';
        try {

            $request->validate([
                'email'    => 'required|string|email|max:255|unique:'.User::class,
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([
                // 'name' => $request->name,
                'uuid'      => Str::uuid()->toString(),
                'type_user' => 'Customer',
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
            ]);

            event(new Registered($user));

            Auth::login($user);

            return Reply::getResponse($slug);
        } catch (ErrorException $e) {
            return $e->getResponse();
        } catch (Throwable $e) {
            throw new ErrorException(['message' => $e->getMessage()]);
        }
    }
}

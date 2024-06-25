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
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Core\Modules\Permission\UseCases\PermissionGet;

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
        $uuid                  = Str::uuid()->toString();
        $email                 = $request->email;
        $password              = $request->password;
        $password_confirmation = $request->password_confirmation;

        try {

            $request->validate([
                'email'    => 'required|string|email|max:255|unique:'.User::class,
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $is_get =  PermissionGet::search((object)['profile' => 'Customer']);
            if (!$is_get->status) throw new ErrorException(['slug' => $is_get->slug]);

            DB::beginTransaction();

            $is_created_user = User::create([
                'id_permission' => $is_get->data->id_permission,
                'uuid'          => $uuid,
                'email'         => $email,
                'password'      => Hash::make($password),
            ]);

            event(new Registered($is_created_user));

            Auth::login($is_created_user);

            DB::commit();

            return Reply::getResponse('register-success');

        } catch (ErrorException $e) {
            DB::rollBack();
            return $e->getResponse();
        } catch (Throwable $e) {
            DB::rollBack();
            throw new ErrorException(['message' => $e->getMessage()]);
        }
    }
}

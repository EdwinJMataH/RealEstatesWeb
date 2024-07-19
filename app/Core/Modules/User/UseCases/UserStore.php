<?php
namespace App\Core\Modules\User\UseCases;
use Throwable;
use App\Models\User;
use App\Core\Helpers\Reply;
use Illuminate\Support\Str;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Core\Modules\User\UseCases\UserValidator;
use App\Core\Modules\Permission\UseCases\PermissionGet;

class UserStore {

    public static function store($request)
    {
        $email    = $request->email;
        $profile  = $request->profile;
        $type     = $request->type;
        $uuid     = Str::uuid()->toString();
        $password = Str::random(8);

        try {
            $is_success = UserValidator::get($request);

            // $is_success = UserValidator::get((object)[
            //     'profile'   => $profile,
            //     'type'      => $type,
            //     'email'     => $email,
            //     'not_empty' => [$email, $profile],
            // ]);
            if (!$is_success->status) throw new ErrorException(['slug' => $is_success->slug]);

            $is_get =  PermissionGet::search((object)[
                'profile'   => $profile,
                'type'      => $type,
            ]);
            if (!$is_get->status) throw new ErrorException(['slug' => $is_get->slug]);

            DB::beginTransaction();

            $is_created_user = User::create([
                'id_permission' => $is_get->data->id_permission,
                'uuid'          => $uuid,
                'email'         => $email,
                'password'      => Hash::make($password),
            ]);

            if (!$is_created_user->id) throw new ErrorException(['slug' => 'register_error']);

            DB::commit();

            return Reply::getResponse('register_success');

        } catch (ErrorException $e) {
            DB::rollBack();
            return $e->getResponse();
        } catch (Throwable $e) {
            DB::rollBack();
            throw new ErrorException(['error' => $e->getMessage()]);
        }
    }
}

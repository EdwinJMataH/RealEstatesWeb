<?php
namespace App\Core\Modules\User\UseCases;
use Throwable;
use App\Models\User;
use App\Core\Helpers\Reply;
use App\Exceptions\ErrorException;

class UserAll {

    public static function index()
    {
        $slug = 'get_success';
        try {

            $users = User::select('name', 'email', 'uuid', 'id_permission')
                    ->where('is_support', 0)
                    ->with(['permission.profile'])
                    ->get();

            $users->transform(function ($user){
                $user->profile = $user->permission->profile->name;
                $user->type    = $user->permission->type;
                unset($user->id_permission);
                unset($user->permission);
                return $user;
            });

            return Reply::getResponse($slug, $users);

        } catch (ErrorException $e) {
            return $e->getResponse();
        } catch (Throwable $e) {
            throw new ErrorException(['message' => $e->getMessage()]);
        }
    }
}

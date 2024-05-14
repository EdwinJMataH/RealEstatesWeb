<?php
namespace App\Core\Modules\User\UseCases;
use Exception;
use Throwable;
use App\Models\UserModel;
use Illuminate\Support\Str;
use App\Core\Helpers\Validation;
use App\Core\Helpers\Response;
use App\Exceptions\ErrorException;
use App\Repositories\ErrorMessagesRepository;

class UserStore {

    public static function store($request)
    {
        $email      = $request->email;
        $profile    = $request->profile;
        $permission = $request->permission;
        $uuid       = Str::uuid()->toString();
        $not_empty  = [$email, $permission];
        $slug = 'register-success';
        try {
            if ($permission == 'Collaborator') $not_empty[] = $profile;

            if ($permission == 'Administrator') $profile = 'Admin';

            $is_empty = Validation::isEmpty($not_empty);
            if (!$is_empty) throw new ErrorException('form-empty');

            $is_created = UserModel::create((object)[
                'columns' => [
                    'email'      => $email,
                    'permission' => $permission,
                    'profile'    => $profile,
                ]
            ]);
            if (!$is_created->status) throw new ErrorException('register-error', $is_created->error);

            return Response::getResponse($slug);

        } catch (ErrorException $e) {
            return $e->getResponse();
        } catch (Throwable $e) {
            throw new ErrorException(null, $e->getMessage());
        }
    }
}
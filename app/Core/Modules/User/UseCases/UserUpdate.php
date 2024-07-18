<?php
namespace App\Core\Modules\User\UseCases;
use Throwable;
use App\Models\User;
use App\Core\Helpers\Reply;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\DB;
use App\Core\Modules\User\UseCases\UserValidator;
use App\Core\Modules\Permission\UseCases\PermissionGet;

class UserUpdate {

    public static function store($request)
    {
        $email   = $request->email;
        $profile = $request->profile;
        $type    = $request->type;
        $uuid    = $request->uuid;

        try {
            if (!$uuid) throw new ErrorException(['slug' => 'uuid_not_found']);

            $is_success = UserValidator::get((object)[
                'profile'   => $profile,
                'type'      => $type,
                'not_empty' => [$email, $profile],
            ]);
            if (!$is_success->status) throw new ErrorException(['slug' => $is_success->slug]);

            $is_get =  PermissionGet::search((object)[
                'profile'   => $profile,
                'type'      => $type,
            ]);
            if (!$is_get->status) throw new ErrorException(['slug' => $is_get->slug]);

            DB::beginTransaction();

            $is_updated = User::where('uuid', $uuid)
                ->update([
                    'id_permission' => $is_get->data->id_permission,
                    'email'         => $email,
                ]);
            if (!$is_updated) throw new ErrorException(['slug' => 'update_error']);

            DB::commit();

            return Reply::getResponse('update_success');

        } catch (ErrorException $e) {
            DB::rollBack();
            return $e->getResponse();
        } catch (Throwable $e) {
            DB::rollBack();
            throw new ErrorException(['error' => $e->getMessage()]);
        }
    }
}

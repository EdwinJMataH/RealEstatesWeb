<?php
namespace App\Core\Modules\Permission\UseCases;
use Throwable;
use App\Models\Permission;
use App\Core\Helpers\Reply;
use App\Exceptions\ErrorException;

class PermissionGet {

    public static function search($request)
    {
        $profile = $request->profile;
        $type    = $request->type ?? 'All';
        try {

            $id_permission = Permission::whereHas('profile', function ($query) use ($profile, $type) {
                $query->where('name', $profile);
            })->where('type', $type)->value('id_permission');


            return Reply::getResponse('get_success', [
                'id_permission' => $id_permission
            ]);

        } catch (ErrorException $e) {
            return $e->getResponse();
        } catch (Throwable $e) {
            throw new ErrorException(['error' => $e->getMessage()]);
        }
    }
}

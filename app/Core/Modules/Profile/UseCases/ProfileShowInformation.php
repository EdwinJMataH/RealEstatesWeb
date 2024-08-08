<?php
namespace App\Core\Modules\Profile\UseCases;
use Throwable;
use App\Models\File;
use App\Models\Permission;
use App\Core\Helpers\Reply;
use App\Exceptions\ErrorException;

class ProfileShowInformation {

    public static function index($request)
    {
        try {
            $user = $request->user();

            $data = [
                'email'   => $user->email,
                'name'    => $user->name,
                'image'   => File::find($user->id_file)->url_temporary,
                'profile' => Permission::find($user->id_permission)->profile->name
            ];

            return Reply::getResponse('get_success', $data);

        } catch (ErrorException $e) {
            return $e->getResponse();
        } catch (Throwable $e) {
            throw new ErrorException(['error' => $e->getMessage()]);
        }
    }
}

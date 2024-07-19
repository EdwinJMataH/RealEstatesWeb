<?php
namespace App\Core\Modules\User\UseCases;
use Throwable;
use App\Models\User;
use App\Core\Helpers\Reply;
use App\Exceptions\ErrorException;
class UserValidator {

    public static function get($request)
    {
        $profile   = $request->profile;
        $type      = $request->type;

        try {

            if ($profile == 'Collaborator' && !in_array($type, ['Creator','Editor']))
                throw new ErrorException(['slug' => 'permission_error']);

            if ($profile == 'Administrator') $request->type = 'All';

            return Reply::getResponse('get_success');

        } catch (ErrorException $e) {
            return $e->getResponse();
        } catch (Throwable $e) {
            throw new ErrorException(['error' => $e->getMessage()]);
        }
    }
}

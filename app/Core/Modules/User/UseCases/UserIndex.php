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

class UserIndex {

    public static function index()
    {
        $slug = 'get-success';
        try {
            $users = UserModel::index();
            if (!$users->status) throw new ErrorException('get-error', $users->error);
            return Response::getResponse($slug, $users->data);

        } catch (ErrorException $e) {
            return $e->getResponse();
        } catch (Throwable $e) {
            throw new ErrorException(null, $e->getMessage());
        }
    }
}
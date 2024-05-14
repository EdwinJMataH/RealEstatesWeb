<?php
namespace App\Core\Modules\Module\UseCases;
use Exception;
use Throwable;
use App\Models\ModuleModel;
use Illuminate\Support\Str;
use App\Core\Helpers\Validation;
use App\Core\Helpers\Response;
use App\Exceptions\ErrorException;
use App\Repositories\ErrorMessagesRepository;

class ModuleIndex {

    public static function index()
    {
        $slug = 'get-success';
        try {
            $modules = ModuleModel::index();
            if (!$modules->status) throw new ErrorException('get-error', $modules->error);
            return Response::getResponse($slug, $modules->data);

        } catch (ErrorException $e) {
            return $e->getResponse();
        } catch (Throwable $e) {
            throw new ErrorException(null, $e->getMessage());
        }
    }
}
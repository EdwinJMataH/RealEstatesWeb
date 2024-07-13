<?php
namespace App\Core\Modules\Profile\UseCases;
use Exception;
use Throwable;
use App\Models\ModuleModel;
use App\Core\Helpers\Reply;
use App\Exceptions\ErrorException;

class ProfileGeneral {

    public static function update()
    {
        $slug = 'get-success';
        try {
            // $modules = ModuleModel::index();
            // if (!$modules->status) throw new ErrorException('get-error', $modules->error);
            // return Reply::getResponse($slug, $modules->data);

        } catch (ErrorException $e) {
            return $e->getResponse();
        } catch (Throwable $e) {
            // throw new ErrorException(null, $e->getMessage());
        }
    }
}

<?php
namespace App\Core\Modules\Module\UseCases;
use Exception;
use Throwable;
use App\Models\Module;
use App\Core\Helpers\Reply;
use App\Models\ModuleModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Core\Helpers\Validation;
use App\Exceptions\ErrorException;
use App\Models\Profile;
use App\Repositories\ErrorMessagesRepository;

class ModuleIndex {

    public static function index($request)
    {
        $slug = 'get-success';
        try {

            $type_user = $request->user()->type_user;
            $modules   = [];

            if ($type_user == 'Administrator') {
                $modules = Module::pluck('id_module');
            }

            if ($type_user == 'Customer') {
                $profile = Profile::where('name', 'Customer')->first();

                $modules = $profile->modules()->pluck('modules.id_module');
            }
            
            return Reply::getResponse($slug, $modules);

        } catch (ErrorException $e) {
            return $e->getResponse();
        } catch (Throwable $e) {
            throw new ErrorException(['message' => $e->getMessage()]);
        }
    }
}

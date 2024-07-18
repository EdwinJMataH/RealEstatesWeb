<?php
namespace App\Core\Modules\User\UseCases;
use Throwable;
use App\Core\Helpers\Reply;
use App\Core\Helpers\Validation;
use App\Exceptions\ErrorException;

class UserValidator {

    public static function get($request)
    {
        $profile   = $request->profile;
        $type      = $request->type;
        $not_empty = $request->not_empty ?? [];

        try {
            if ($profile == 'Collaborator') $not_empty[] = $type;

            if ($profile == 'Administrator') $type = 'All';

            $is_empty = Validation::isEmpty($not_empty);

            if (!$is_empty) throw new ErrorException(['slug' => 'form_empty']);

            return Reply::getResponse('get_success');

        } catch (ErrorException $e) {
            return $e->getResponse();
        } catch (Throwable $e) {
            throw new ErrorException(['error' => $e->getMessage()]);
        }
    }
}

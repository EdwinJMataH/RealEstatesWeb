<?php
namespace App\Core\Modules\Profile\UseCases;
use Exception;
use Throwable;
use App\Core\Helpers\Reply;
use App\Models\ModuleModel;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileUpdateInformation {

    public static function update($request)
    {
        try {
            $request->validated();

            $request->user()->fill($request->validated());

            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }
            DB::beginTransaction();

            $request->user()->save();


            DB::commit();

            return Reply::getResponse('update-success');

        } catch (ErrorException $e) {
            DB::rollBack();
            return $e->getResponse();
        } catch (Throwable $e) {
            DB::rollBack();
            throw new ErrorException(['error' => $e->getMessage()]);
        }
    }
}

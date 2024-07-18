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

class ProfileUpdatePassword {

    public static function update($request)
    {

        try {
            $password  = $request->password;

            $request->validated();

            DB::beginTransaction();

            $request->user()->update([
                'password' => Hash::make($password)
            ]);

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

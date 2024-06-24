<?php
namespace App\Core\Modules\User\UseCases;
use Throwable;
use App\Models\User;
use App\Core\Helpers\Reply;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\DB;

class UserDestroy {

    public static function store($request)
    {
        $uuid = $request->uuid;

        try {
            if (!$uuid) throw new ErrorException(['slug' => 'uuid-not-found']);

            $to_delete = User::where('uuid', $uuid);

            $user = $to_delete->first();

            DB::beginTransaction();

            $is_destroyed = $to_delete->delete();
            if (!$is_destroyed) throw new ErrorException(['slug' => 'delete-error']);

            DB::table('sessions')->where('user_id', $user->id)->delete();

            DB::commit();

            return Reply::getResponse('delete-success');

        } catch (ErrorException $e) {
            DB::rollBack();
            return $e->getResponse();
        } catch (Throwable $e) {
            DB::rollBack();
            throw new ErrorException(['error' => $e->getMessage()]);
        }
    }
}

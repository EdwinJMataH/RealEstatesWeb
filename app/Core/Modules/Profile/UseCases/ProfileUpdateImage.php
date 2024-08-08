<?php
namespace App\Core\Modules\Profile\UseCases;
use Throwable;
use App\Models\User;
use App\Core\Helpers\Reply;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\DB;
use App\Core\Modules\File\UseCases\StoreFile;

class ProfileUpdateImage {

    public static function update($request)
    {
        try {
            $files   = $request->file();
            $id_user = $request->user()->id;

            DB::beginTransaction();

            $is_save = (new StoreFile((object)[
                'disk'           => 'image_profile',
                'privacy'        => 'public',
                'allowed_format' => ['jpeg', 'jpg', 'png'],
                'files'          => $files
            ]))->save();
            if(!$is_save->status) throw new ErrorException(['slug' => $is_save->slug]);

            User::where('id',$id_user)->update(['id_file' => $is_save->data->id_files->id_file]);

            DB::commit();

            return Reply::getResponse('register_success');

        } catch (ErrorException $e) {
            DB::rollBack();
            return $e->getResponse();
        } catch (Throwable $e) {
            DB::rollBack();
            throw new ErrorException(['error' => $e->getMessage()]);
        }
    }
}

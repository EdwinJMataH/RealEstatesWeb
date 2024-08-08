<?php

namespace App\Models;

use PDOException;
use App\Core\Helpers\Reply;
use Illuminate\Support\Str;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class File extends Model
{
    use HasFactory;

    /**
     * table
     *
     * @var string
     */
    protected $table = 'files';

    /**
     * primaryKey
     *
     * @var string
     */
    protected $primaryKey = 'id_file';

    /**
     * hidden
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    /**
     * user
     *
     * @return HasOne
     */
    public function user() : HasOne
    {
        return $this->hasOne(User::class, 'id_file', 'id_file');
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return object
     */
    public function store($request) : object
    {
        try {
            $file_names  = $request->file_names ?? [];
            $to_insert   = $request->to_insert ?? [];
            $tenant_id   = $request->tenant_id ?? null;
            $id_files    = [];
            // $in_landlord = $request->in_landlord ?? false;
            // $landlord_drive_ids = [];

            // if(!is_null($tenant_id)){

                DB::beginTransaction();

                $is_save = DB::table($this->table)->insert($to_insert);

                if (!$is_save) throw new ErrorException(['error' => 'register_error']);

                DB::commit();

                $id_files = DB::table($this->table)
                        ->whereIn('name', $file_names)
                        ->pluck('id_file')
                        ->toArray();

                $id_files = array_map(function($value){
                    return (object)[
                        'id_file' => $value,
                        'uuid'    => Str::uuid()->toString()
                    ];
                }, $id_files);
            // }


            return Reply::getResponse('process_success', [
                'id_files' => count($id_files) > 1 ? $id_files : $id_files[0]
            ]);

        } catch (ErrorException $e) {
            DB::rollBack();
            return $e->getResponse();
        } catch (PDOException $e) {
            DB::rollBack();
            throw new ErrorException(['error' => $e->getMessage()]);
        }
    }
}

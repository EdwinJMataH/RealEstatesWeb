<?php

namespace App\Core\Modules\File\UseCases;

use Throwable;
use App\Models\File;
use App\Core\Helpers\Reply;
use Illuminate\Support\Str;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class StoreFile  {

    protected string  $type_storage;
    protected ?string $tenant_id;
    protected ?string $disk;
    protected ?string $multiple;
    protected ?string $privacy;
    protected string  $folder;
    protected array   $allowed_format;
    protected ?array  $files;

    private array     $folders      = ['image_profile' => 'image/profile'];
    private array     $allowed_disk = ['image_profile'];
    private array     $file_names;
    private array     $file_info = [];
    private array     $to_insert = [];

    public function __construct(object $attributes){
        $this->type_storage   = config('env.storage_config');
        $this->tenant_id      = $attributes->tenant_id ?? null;
        $this->disk           = $attributes->disk ?? '';
        $this->multiple       = $attributes->multiple ?? false;
        $this->privacy        = $attributes->privacy ?? 'private';
        $this->files          = $attributes->files ?? [];
        $this->allowed_format = $attributes->allowed_format ?? [];

    }

    public function save() {
        try {

            if (!in_array($this->disk, $this->allowed_disk)) throw new ErrorException(['slug' => 'disk_not_found']);

            if (!count($this->files)) throw new ErrorException(['slug' => 'files_empty']); //pendinte por ubicar

            if (count($this->files) > 1 && $this->multiple != true) throw new ErrorException(['slug' => 'files_number_allowed']);

            $this->folder = $this->folders[$this->disk];

            $this->getFileInformation();

            if ($this->type_storage == 'default') {
                $this->saveFilesInLaravel();
            }

            if ($this->type_storage == 'google-cloud') {
                // $this->saveFilesInGoogleCloud();
            }

            $is_save = (new File())->store((object)[
                'to_insert'  => $this->to_insert,
                'file_names' => $this->file_names,
            ]);
            if(!$is_save->status) throw new ErrorException(['slug' => 'file_save_error']);

            return Reply::getResponse('register_success', $is_save->data);

        } catch (ErrorException $e) {
            return $e->getResponse();
        } catch (Throwable $e) {
            throw new ErrorException(['error' => $e->getMessage()]);
        }
    }

    private function getFileInformation(){
        foreach ($this->files as $key => $file) {
            $name          = null;
            $name_original = $file->getClientOriginalName();
            $extension     = pathinfo($name_original);
            $extension     = $extension['extension'] ?? 'ERROR_SYSTEM';

            if (!in_array(trim(strtolower($extension)), $this->allowed_format)) throw new ErrorException(['slug' => 'file_extension_error']);

            $name = Str::uuid()->toString().'.'.$extension;

            $this->file_info[] = (object) [
                'name_original' => $name_original,
                'name'          => $name,
                'size'          => $file->getSize(),
                'type'          => $file->getMimeType(),
                'content'       => $file,
                'disk'          => $this->disk,
                'privacy'       => $this->privacy
            ];

            $this->file_names[] = $name;
        }
    }

    //Storage Laravel (default)
    private  function saveFilesInLaravel() {
        foreach ($this->file_info as $value) {
            $is_save = $this->saveStorage((object)[
                'name'       => $value->name,
                'content'    => $value->content,
            ]);
            if(!$is_save->status) throw new ErrorException(['error' => 'file_error']);

            unset($value->content);

            $this->to_insert[] = [
                ...(array)$value,
                'path'          => $is_save->data->path,
                'url_temporary' => $is_save->data->url_temporary
            ];
        }
    }

    private function saveStorage($request){
        try {
            $year       = date("Y");
            $month      = strtolower(date("F"));
            $name       = $request->name;
            $content    = $request->content;
            $complement = is_null($this->tenant_id) ? "$this->folder/$year/$month/" : "$this->tenant_id/$this->folder/$year/$month/";
            $path       = "storage/".$complement;

            $storage_path = "app/public/".$complement;
            $storage_url  = env('APP_URL').$path.$name;

            Config::set("filesystems.disks.".$this->disk,[
                'driver'     => 'local',
                'root'       => storage_path($storage_path),
                'url'        => $storage_url,
                'visibility' => 'public',
                'throw'      => false,
            ]);

            Storage::disk($this->disk)->put($name, file_get_contents($content));

            if(!file_exists($path.$name)) throw new ErrorException(['slug' => 'file_not_exists']);

            return Reply::getResponse('process_success', [
                'path'          => $path.$name,
                'file'          => $name,
                'only_path'     => $path,
                'url_temporary' => $storage_url
            ]);

        } catch (ErrorException $e) {
            return $e->getResponse();
        } catch (Throwable $e) {
            throw new ErrorException(['error' => $e->getMessage()]);
        }
    }
}

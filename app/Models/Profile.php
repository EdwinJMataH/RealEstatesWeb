<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Profile extends Model
{
    use HasFactory;

    /**
     * table
     *
     * @var string
     */
    protected $table = 'profiles';

    /**
     * primaryKey
     *
     * @var string
     */
    protected $primaryKey = 'id_profile';

    /**
     * keyType
     *
     * @var string
     */
    protected $keyType = 'int';

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
     * modules
     *
     * @return BelongsToMany
     */
    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(Module::class, 'profiles_modules', 'id_profile', 'id_module');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Module extends Model
{
    use HasFactory;

    /**
     * table
     *
     * @var string
     */

    protected $table = 'modules';

    /**
     * primaryKey
     *
     * @var string
     */

    protected $primaryKey = 'id_module';

    /**
     * incrementing
     *
     * @var bool
     */

    public $incrementing = false;

    /**
     * keyType
     *
     * @var string
     */

    protected $keyType = 'string';

    /**
     * hidden
     *
     * @var array
     */

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * profiles
     *
     * @return BelongsToMany
     */

    public function profiles(): BelongsToMany
    {
        return $this->belongsToMamy(Profile::class, 'profiles_modules', 'id_module', 'id_profile');
    }
}

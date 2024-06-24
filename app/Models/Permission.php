<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permission extends Model
{
    use HasFactory;

    /**
     * table
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * primaryKey
     *
     * @var string
     */
    protected $primaryKey = 'id_permission';

    /**
     * keyType
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'id_profile',
        'type',
    ];


    /**
     * profiles
     *
     * @return BelongsTo
     */
    public function profile() : BelongsTo
    {
        return $this->belongsTo(Profile::class, 'id_profile', 'id_profile');
    }

    public function user() : HasMany
    {
        return $this->hasMany(User::class, 'id_permission', 'id_permission');
    }
}

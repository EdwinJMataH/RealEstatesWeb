<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileModule extends Model
{
    use HasFactory;

    /**
     * table
     *
     * @var string
     */
    protected $table = 'profiles_modules';
}

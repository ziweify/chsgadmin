<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\UserLogin
 *
 * @method static \Illuminate\Database\Eloquent\Builder|UserLogin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLogin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLogin query()
 * @mixin \Eloquent
 */
class UserLogin extends BaseModel
{
    protected $table = 'user_login';
    public $timestamps = false;
    
    protected $guarded = [];
}

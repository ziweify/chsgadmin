<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\UserRoom
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Userroom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Userroom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Userroom query()
 * @mixin \Eloquent
 */
class Userroom extends BaseModel
{
    protected $table = 'userroom';
    public $timestamps = false;
    
    protected $guarded = [];
}

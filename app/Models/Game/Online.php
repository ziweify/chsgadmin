<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Online
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Online newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Online newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Online query()
 * @mixin \Eloquent
 */
class Online extends BaseModel
{
    protected $table = 'online';
    public $timestamps = false;
    
    protected $guarded = [];
}

<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Mclass
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Mclass newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mclass newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mclass query()
 * @mixin \Eloquent
 */
class Mclass extends BaseModel
{
    protected $table = 'class';
    public $timestamps = false;
    
    protected $guarded = [];
}

<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Lib
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Lib newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lib newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lib query()
 * @mixin \Eloquent
 */
class Lib extends BaseModel
{
    protected $table = 'lib';
    public $timestamps = false;
    
    protected $guarded = [];
}

<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Log
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Log newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Log newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Log query()
 * @mixin \Eloquent
 */
class Log extends BaseModel
{
    protected $table = 'log';
    public $timestamps = false;
    
    protected $guarded = [];
}

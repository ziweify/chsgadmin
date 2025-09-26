<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Warn
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Warn newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Warn newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Warn query()
 * @mixin \Eloquent
 */
class Warn extends BaseModel
{
    protected $table = 'warn';
    public $timestamps = false;
    
    protected $guarded = [];
}

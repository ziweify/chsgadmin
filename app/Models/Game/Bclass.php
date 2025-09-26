<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Bclass
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Bclass newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bclass newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bclass query()
 * @mixin \Eloquent
 */
class Bclass extends BaseModel
{
    protected $table = 'bclass';
    public $timestamps = false;
    
    protected $guarded = [];
}

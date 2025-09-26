<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Sclass
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Sclass newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sclass newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sclass query()
 * @mixin \Eloquent
 */
class Sclass extends BaseModel
{
    protected $table = 'sclass';
    public $timestamps = false;
    
    protected $guarded = [];
}

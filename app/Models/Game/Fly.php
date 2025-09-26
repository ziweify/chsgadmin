<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Fly
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Fly newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fly newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fly query()
 * @mixin \Eloquent
 */
class Fly extends BaseModel
{
    protected $table = 'fly';
    public $timestamps = false;
    
    protected $guarded = [];
}

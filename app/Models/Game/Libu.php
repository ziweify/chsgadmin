<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Libu
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Libu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Libu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Libu query()
 * @mixin \Eloquent
 */
class Libu extends BaseModel
{
    protected $table = 'libu';
    public $timestamps = false;
    
    protected $guarded = [];
}

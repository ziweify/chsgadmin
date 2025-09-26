<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Game
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game query()
 * @mixin \Eloquent
 */
class Game extends BaseModel
{
    protected $table = 'game';
    public $timestamps = false;
    
    protected $guarded = [];
}

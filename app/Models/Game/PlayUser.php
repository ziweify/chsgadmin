<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\PlayUser
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PlayUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlayUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlayUser query()
 * @mixin \Eloquent
 */
class PlayUser extends BaseModel
{
    protected $table = 'play_user';
    public $timestamps = false;
    
    protected $guarded = [];
}

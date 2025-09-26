<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Gamemsg
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Gamemsg newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gamemsg newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gamemsg query()
 * @mixin \Eloquent
 */
class Gamemsg extends BaseModel
{
    protected $table = 'gamemsg';
    public $timestamps = false;
    protected $guarded = [];
}

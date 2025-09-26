<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Roomhistory
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Roomhistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Roomhistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Roomhistory query()
 * @mixin \Eloquent
 */
class Roomhistory extends BaseModel
{
    protected $table = 'roomhistory';
    public $timestamps = false;
    protected $guarded = [];
}

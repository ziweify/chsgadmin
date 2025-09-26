<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\FollowplanTomember
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Att newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Att newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Att query()
 * @mixin \Eloquent
 */
class FollowplanTomember extends BaseModel
{
    protected $table = 'followplan_tomember';
    public $timestamps = false;
    
    protected $guarded = [];
}

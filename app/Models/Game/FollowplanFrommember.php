<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\FollowplanFrommember
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Att newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Att newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Att query()
 * @mixin \Eloquent
 */
class FollowplanFrommember extends BaseModel
{
    protected $table = 'followplan_frommember';
    public $timestamps = false;
    
    protected $guarded = [];
}

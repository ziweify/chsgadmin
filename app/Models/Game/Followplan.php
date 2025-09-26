<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Followplan
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Att newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Att newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Att query()
 * @mixin \Eloquent
 */
class Followplan extends BaseModel
{
    protected $table = 'followplan';
    public $timestamps = false;
    
    protected $guarded = [];

    public function followplantomembers(){
        return $this->hasMany(FollowplanTomember::class, 'followplan_id', 'id');
    }
}

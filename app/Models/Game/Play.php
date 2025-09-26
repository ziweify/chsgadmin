<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Play
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Play newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Play newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Play query()
 * @mixin \Eloquent
 */
class Play extends BaseModel
{
    protected $table = 'play';
    public $timestamps = false;
    
    protected $guarded = [];

    public function bclass()
    {
        return $this->hasOne(Bclass::class, 'bid', 'bid')->select(['bid', 'name']);
    }

    public function sclass()
    {
        return $this->hasOne(Sclass::class, 'sid', 'sid')->select(['sid', 'name']);
    }

    public function mclass()
    {
        return $this->hasOne(Mclass::class, 'cid', 'cid')->select(['cid', 'name','mtype']);
    }
}

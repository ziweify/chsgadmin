<?php

namespace App\Models\Game;



use App\Models\BaseModel;

/**
 * App\Models\Game\Peilv
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Peilv newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Peilv newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Peilv query()
 * @mixin \Eloquent
 */
class Peilv extends BaseModel
{
    protected $table = 'peilv';
    public $timestamps = false;
    
    protected $guarded = [];
}

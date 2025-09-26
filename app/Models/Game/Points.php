<?php

namespace App\Models\Game;


use App\Models\BaseModel;

/**
 * App\Models\Game\Points
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Points newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Points newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Points query()
 * @mixin \Eloquent
 */
class Points extends BaseModel
{
    protected $table = 'points';
    public $timestamps = false;
    
    protected $guarded = [];
}

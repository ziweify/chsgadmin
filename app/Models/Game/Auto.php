<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Auto
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Auto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Auto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Auto query()
 * @mixin \Eloquent
 */
class Auto extends BaseModel
{
    protected $table = 'auto';
    public $timestamps = false;
    
    protected $guarded = [];
}

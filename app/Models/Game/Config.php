<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Config
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Config newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Config newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Config query()
 * @mixin \Eloquent
 */
class Config extends BaseModel
{
    protected $table = 'config';
    public $timestamps = false;
    
    protected $guarded = [];
}

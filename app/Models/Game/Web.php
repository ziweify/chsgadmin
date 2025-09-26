<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Web
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Web newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Web newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Web query()
 * @mixin \Eloquent
 */
class Web extends BaseModel
{
    protected $table = 'web';
    public $timestamps = false;
    
    protected $guarded = [];
}

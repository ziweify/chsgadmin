<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\LibModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Lib newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lib newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lib query()
 * @mixin \Eloquent
 */
class LibModel extends BaseModel
{
    public $timestamps = false;
    
    protected $guarded = [];
}

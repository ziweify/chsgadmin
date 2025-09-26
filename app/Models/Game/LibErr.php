<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\LibErr
 *
 * @method static \Illuminate\Database\Eloquent\Builder|LibErr newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LibErr newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LibErr query()
 * @mixin \Eloquent
 */
class LibErr extends BaseModel
{
    protected $table = 'lib_err';
    public $timestamps = false;
    
    protected $guarded = [];
}

<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\LibTotal
 *
 * @method static \Illuminate\Database\Eloquent\Builder|LibTotal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LibTotal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LibTotal query()
 * @mixin \Eloquent
 */
class LibTotal extends BaseModel
{
    protected $table = 'lib_total';
    public $timestamps = false;
    
    protected $guarded = [];
}

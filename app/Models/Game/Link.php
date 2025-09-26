<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Link
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Link newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link query()
 * @mixin \Eloquent
 */
class Link extends BaseModel
{
    protected $table = 'link';
    public $timestamps = false;
    
    protected $guarded = [];
}

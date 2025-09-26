<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Apply
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Apply newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Apply newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Apply query()
 * @mixin \Eloquent
 */
class Apply extends BaseModel
{
    protected $table = 'apply';
    public $timestamps = false;
    protected $guarded = [];
}

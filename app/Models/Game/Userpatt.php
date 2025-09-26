<?php

namespace App\Models\Game;



use App\Models\BaseModel;

/**
 * App\Models\Game\User
 *
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @mixin \Eloquent
 */
class Userpatt extends BaseModel
{
    protected $table = 'userpatt';
    public $timestamps = false;
    
    protected $guarded = [];
}

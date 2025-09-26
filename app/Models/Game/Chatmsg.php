<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Chatmsg
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Chatmsg newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chatmsg newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chatmsg query()
 * @mixin \Eloquent
 */
class Chatmsg extends BaseModel
{
    protected $table = 'chatmsg';
    public $timestamps = false;
    protected $guarded = [];
}

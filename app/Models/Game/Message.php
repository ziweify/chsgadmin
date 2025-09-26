<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Message
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message query()
 * @mixin \Eloquent
 */
class Message extends BaseModel
{
    protected $table = 'message';
    public $timestamps = false;
    
    protected $guarded = [];
}

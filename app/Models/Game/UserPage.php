<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\UserPage
 *
 * @method static \Illuminate\Database\Eloquent\Builder|UserPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPage query()
 * @mixin \Eloquent
 */
class UserPage extends BaseModel
{
    protected $table = 'user_page';
    public $timestamps = false;
    
    protected $guarded = [];
}

<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\UserEdit
 *
 * @method static \Illuminate\Database\Eloquent\Builder|UserEdit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEdit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEdit query()
 * @mixin \Eloquent
 */
class UserEdit extends BaseModel
{
    protected $table = 'user_edit';
    public $timestamps = false;
    
    protected $guarded = [];

    public function followplan(){
        return $this->belongsTo(Followplan::class, 'other', 'id');
    }
}

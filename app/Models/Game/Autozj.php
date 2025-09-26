<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Autozj
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Autozj newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Autozj newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Autozj query()
 * @mixin \Eloquent
 */
class Autozj extends BaseModel
{
    protected $table = 'autozjconfig';
    public $timestamps = false;
    
    protected $guarded = [];

    public function user(){
        return $this->hasOne(User::class, 'userid', 'userid')
            ->select(['username','userid','sy','jetotal']);
    }
}

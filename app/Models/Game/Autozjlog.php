<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Autozjlog
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Autozjlog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Autozjlog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Autozjlog query()
 * @mixin \Eloquent
 */
class Autozjlog extends BaseModel
{
    protected $table = 'autozjlog';
    public $timestamps = false;
    
    protected $guarded = [];

    public function user(){
        return $this->hasOne(User::class, 'userid', 'userid')->select(['username','userid','layer']);
    }

    public function admin(){
        return $this->hasOne(Admin::class, 'adminid', 'userid')->select(['adminname','adminid']);
    }
}

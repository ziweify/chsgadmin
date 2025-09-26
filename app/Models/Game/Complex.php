<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Complex
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Auto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Auto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Auto query()
 * @mixin \Eloquent
 */
class Complex extends BaseModel
{
    protected $table = 'complex';
    public $timestamps = false;
    
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class, 'userid', 'userid')->select(['userid','kmoney','status']);
    }
}

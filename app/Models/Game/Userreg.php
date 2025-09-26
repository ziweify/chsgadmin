<?php

namespace App\Models\Game;

use App\Models\BaseModel;
use Illuminate\Foundation\Auth\User as Authenticatable;


/**
 * App\Models\Game\UserRoombalance
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Userreg newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Userreg newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Userreg query()
 * @mixin \Eloquent
 */
class Userreg extends Authenticatable
{
    protected $table = 'userreg';
    public $timestamps = false;
    
    protected $guarded = [];

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getKeyName(){
        return 'userid'; // 将主键改为 userid
    }

    public function user(){
        return $this->hasOne(User::class, 'userid', 'userid');
    }
}

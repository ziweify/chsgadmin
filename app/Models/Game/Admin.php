<?php

namespace App\Models\Game;



use App\Models\BaseModel;

/**
 * App\Models\Game\Admin
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @mixin \Eloquent
 */
class Admin extends BaseModel
{
    protected $table = 'admins';
    public $timestamps = false;
    
    protected $guarded = [];

    public function fadmin(){
        return $this->belongsTo(Admin::class, 'fid', 'adminid')->select(['adminid','adminname','level']);
    }
}

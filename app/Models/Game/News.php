<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\News
 *
 * @method static \Illuminate\Database\Eloquent\Builder|News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News query()
 * @mixin \Eloquent
 */
class News extends BaseModel
{
    protected $table = 'news';
    public $timestamps = false;
    
    protected $guarded = [];

    public function admin(){
        return $this->belongsTo(Admin::class, 'adminid', 'adminid')->select(['adminid','adminname']);
    }
}

<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Gamecs
 *
 * @property-read \App\Models\Game\Game|null $tgame
 * @method static \Illuminate\Database\Eloquent\Builder|Gamecs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gamecs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gamecs query()
 * @mixin \Eloquent
 * @property-read \App\Models\Game\Game|null $game
 */
class Gamecs extends BaseModel
{
    protected $table = 'gamecs';
    public $timestamps = false;
    
    protected $guarded = [];

    public function searchUseridAttr($query, $value)
    {
        if (is_array($value))
            $query->whereIn('userid', $value);
        else
            $query->where('userid', $value);
    }

    public function game(){
        return $this->hasOne(Game::class, 'gid', 'gid')
            ->select(['id as ggid','gname', 'sgname', 'fenlei', 'flname', 'fast', 'class', 'gid','isnews','xsort','lotCode','kjurl']);
    }

    public function gameone(){
        return $this->hasOne(Game::class, 'gid', 'gid')
            ->where('ifopen', 1)
            ->select(['gname', 'fenlei', 'lottery', 'fast', 'gid','xsort']);
    }

    public function tgame(){
        return $this->hasOne(Game::class, 'gid', 'gid');
    }
}

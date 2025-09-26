<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Gamezc
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Gamezc newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gamezc newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gamezc query()
 * @mixin \Eloquent
 */
class Gamezc extends BaseModel
{
    protected $table = 'gamezc';
    public $timestamps = false;
    
    protected $guarded = [];

    public function searchUseridAttr($query, $value)
    {
        if (is_array($value))
            $query->whereIn('userid', $value);
        else
            $query->where('userid', $value);
    }

    public function game()
    {
        return $this->hasOne(Game::class, 'gid', 'gid')
            ->field(['gname', 'sgname', 'fenlei', 'flname', 'fast', 'class', 'gid'])->bind([
            'gname' => 'gname',
            'sgname' => 'sgname',
            'fenlei' => 'fenlei',
            'flname' => 'flname',
            'fast' => 'fast',
            'class' => 'class',
        ]);
    }
}

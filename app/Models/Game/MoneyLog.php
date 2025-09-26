<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\MoneyLog
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MoneyLog query()
 * @mixin \Eloquent
 */
class MoneyLog extends BaseModel
{
    protected $table = 'money_log';
    public $timestamps = false;
    
    protected $guarded = [];

    public function user(){
        return $this->hasOne(User::class, 'userid', 'userid')
            ->field(['username','userid'])->bind([
                'username' => 'username',
            ]);
    }

    public function searchUseridAttr($query, $value){
        if ($value !== '') $query->where('userid',$value);
    }

    public function searchTypeAttr($query, $value){
        if ($value !== '') $query->where('type',$value);
    }

    public function searchTimeAttr($query, $value, $data)
    {
        if (is_array($value)) {
            $startTime = $value[0] ?? date('Y-m-d');
            $endTime = $value[1] ?? date('Y-m-d');
            $startTime = strtotime($startTime);
            $endTime = strtotime($endTime);
            if ($startTime || $endTime) {
                if ($startTime == $endTime) {
                    $endTime = $endTime + 86400;
                }
                $query->whereBetween('time', [$startTime, $endTime]);
            }
        }else{
            $query->whereTime('time', '>=', strtotime($value))->whereTime('time', '<=', strtotime($value));
        }
    }
}

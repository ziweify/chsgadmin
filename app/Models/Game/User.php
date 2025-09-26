<?php

namespace App\Models\Game;



use App\ort\common\Constants;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\Game\User
 *
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @mixin \Eloquent
 */
class User extends Authenticatable implements JWTSubject
{
    protected $table = 'user';
    public $timestamps = false;
    
    protected $guarded = [];
    //指定主键
    protected $primaryKey = 'userid';

    public function puser(){
        return $this->hasOne(User::class, 'userid', 'fid')
            ->select(['username', 'layer','userid']);
    }

    public function userreg(){
        return $this->hasOne(Userreg::class, 'userid', 'userid')->select(['username', 'userid','name','status','google_open','regtime']);
    }

    public function userroom(){
        return $this->hasOne(Userroom::class, 'userid', 'userid');
    }

    public function gamezc(){
        return $this->hasOne(Gamezc::class, 'userid', 'userid')
            ->field(['zc', 'upzc','userid','flytype'])->bind([
                'zc' => 'zc',
                'upzc' => 'upzc',
                'flytype' => 'flytype',
            ]);
    }

    // 添加与Online表的关联关系
    public function online(){
        return $this->hasOne(Online::class, 'userid', 'userid')
            ->where('ruid', function($query) {
                $query->select('ruid')->from('user')->whereColumn('user.userid', 'online.userid');
            });
    }

    public static function getonline($uid){
        if ($uid == Constants::$SUID) {
            $db = Db::connection();
            $rs = $db->select("select count(id) as count from x_online where userid not in(select adminid from x_admins where ifhide=1)");
            $num = $rs[0]['count'] ? $rs[0]['count'] : 0;
            return $num;
        }
        $layer = self::transuser($uid, "layer");
        return self::where(['fid'.$layer=>$uid,'online'=>1])->count('id');
    }

    public static function transuser($uid, $cols){
        return User::where('userid', $uid)->value($cols);
    }

    public function getJWTIdentifier()
    {
        // TODO: Implement getJWTIdentifier() method.
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return ['userinfo'=>$this];
    }
}

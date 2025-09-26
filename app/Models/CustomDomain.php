<?php

namespace App\Models;


/**
 * App\Models\CustomDomain
 *
 * @property int $id 主键
 * @property int|null $platform_type 平台类型
 * @property int|null $custom_id 客户ID
 * @property string|null $domain 域名
 * @property int|null $type 类型
 * @property int|null $status 状态 1：启用 0：禁用
 * @property string|null $remark 备注
 * @property int|null $create_time 创建时间
 * @property int|null $update_time 更新时间
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDomain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDomain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDomain query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDomain whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDomain whereCustomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDomain whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDomain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDomain wherePlatformType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDomain whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDomain whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDomain whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomDomain whereUpdateTime($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Custom|null $custom
 */
class CustomDomain extends BaseModel
{
    protected $table = 'custom_domain';
    public $timestamps = false;
    //设置固定的数据库连接
    

    public function custom()
    {
        return $this->belongsTo(Custom::class,'custom_id','id');
    }
}

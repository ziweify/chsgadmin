<?php

namespace App\Models;

/**
 * App\Models\Custom
 *
 * @property int $id 主键
 * @property string $name 客户名称
 * @property int $overtime 到期时间
 * @property int|null $platform_type 平台类型 1:138 2:idc
 * @property string|null $remark 备注
 * @property string|null $kjw_dh_domain 开奖网导航域名
 * @property string|null $kjw_yw_domain 开奖网业务域名
 * @property int|null $status 状态 1：启用 0：禁用
 * @property int|null $create_time 创建时间
 * @property int|null $update_time 更新时间
 * @method static \Illuminate\Database\Eloquent\Builder|Custom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Custom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Custom query()
 * @method static \Illuminate\Database\Eloquent\Builder|Custom whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Custom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Custom whereKjwDhDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Custom whereKjwYwDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Custom whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Custom whereOvertime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Custom wherePlatformType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Custom whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Custom whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Custom whereUpdateTime($value)
 * @mixin \Eloquent
 */
class Custom extends BaseModel
{
    protected $table = 'custom';
    public $timestamps = false;
    
}

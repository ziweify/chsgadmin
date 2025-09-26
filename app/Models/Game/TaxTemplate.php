<?php

namespace App\Models\Game;

use App\Models\BaseModel;


/**
 * App\Models\Game\Att
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Att newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Att newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Att query()
 * @mixin \Eloquent
 */
class TaxTemplate extends BaseModel
{
    protected $table = 'tax_template';
    public $timestamps = false;
    
    protected $guarded = [];
}

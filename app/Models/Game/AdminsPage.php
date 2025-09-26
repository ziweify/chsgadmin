<?php

namespace App\Models\Game;


use App\Models\BaseModel;

/**
 * App\Models\Game\AdminsPage
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AdminsPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminsPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminsPage query()
 * @mixin \Eloquent
 */
class AdminsPage extends BaseModel
{
    protected $table = 'admins_page';
    public $timestamps = false;
    
    protected $guarded = [];
}

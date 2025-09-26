<?php


namespace App\Models\Kjw;

use App\Models\BaseModel;


class Fedback extends BaseModel
{
    protected $table = 'fedback';
    public $timestamps = false;
    protected $connection = 'kjw';
    protected $guarded = [];

}

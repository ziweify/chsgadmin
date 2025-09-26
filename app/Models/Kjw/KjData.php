<?php


namespace App\Models\Kjw;

use App\Models\BaseModel;


class KjData extends BaseModel
{
    //protected $table = 'kj100';
    public $timestamps = false;
    protected $connection = 'kjw';
    protected $guarded = [];
}

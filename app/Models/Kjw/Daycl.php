<?php


namespace App\Models\Kjw;


use App\Models\BaseModel;

class Daycl extends BaseModel
{
    protected $table = 'daycl';
    public $timestamps = false;
    protected $connection = 'kjw';
    protected $guarded = [];
}

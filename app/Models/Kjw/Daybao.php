<?php

namespace App\Models\Kjw;


use App\Models\BaseModel;

class Daybao  extends BaseModel
{
    protected $table = 'daybao';
    public $timestamps = false;
    protected $connection = 'kjw';
    protected $guarded = [];
}

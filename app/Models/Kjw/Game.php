<?php


namespace App\Models\Kjw;

use App\Models\BaseModel;


class Game extends BaseModel
{
    protected $table = 'game';
    public $timestamps = false;
    protected $connection = 'kjw';
    protected $guarded = [];
}

<?php

namespace App\ort\kjw;

use App\Models\Kjw\KjData;

class CommonService
{
    public static function getKjmodel($gid){
        $kjServices = new KjData();
        $kjServices->setTable("kj".$gid);
        return $kjServices;
    }
}

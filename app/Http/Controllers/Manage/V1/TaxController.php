<?php

namespace App\Http\Controllers\Manage\V1;


use App\Http\Controllers\Manage\ManageAuthController;
use App\ort\sgwin\Json;
use App\service\TaxService;
use Illuminate\Http\Request;

class TaxController extends ManageAuthController
{
    public function __construct(Request $request){
        parent::__construct($request);
    }

    public function list(Request $request){
        $userid = $this->uid;
        (new TaxService())->list($request,$userid);
        return view('common.tax.list');
    }

    public function saveTax(Request $request){
        $userid = $this->uid;
        $res = (new TaxService())->saveTax($request,$userid,$this->adminid);
        if($res['code'] == 0){
            return Json::error($res['msg']);
        }
        return Json::success($res['msg']);
    }

    public function savetax_start_bishu(Request $request){
        $userid = $this->uid;
        $res = (new TaxService())->savetax_start_bishu($request,$userid);
        if($res['code'] == 0){
            return Json::error($res['msg']);
        }
        return Json::success($res['msg']);
    }

    public function bets(Request $request){
        $userid = $this->uid;
        (new TaxService())->bets($request,$userid,$this->adminid);
        return view('common.tax.bets');
    }

    public function resetTax(Request $request){
        $userid = $this->uid;
        $res = (new TaxService())->resetTax($request,$userid);
        if($res['code'] == 0){
            return Json::error($res['msg']);
        }
        return Json::success($res['msg']);
    }

    public function resetUserTax(Request $request){
        $userid = $this->uid;
        $res = (new TaxService())->resetUserTax($request,$userid,$this->adminid);
        if($res['code'] == 0){
            return Json::error($res['msg']);
        }
        return Json::success($res['msg']);
    }

    public function setting(Request $request){
        $userid = $this->uid;
        (new TaxService())->setting($request,$userid);
        return view('common.tax.setting');
    }

    public function querytax(Request $request){
        $userid = $this->uid;
        $res = (new TaxService())->querytax($request,$userid);
        if($res['code'] == 0){
            return Json::error($res['msg']);
        }
        return Json::success($res['msg'],['totaltax'=>$res['totaltax']]);
    }

    public function cleartaxbywhere(Request $request){
        $userid = $this->uid;
        $res = (new TaxService())->cleartaxbywhere($request,$userid,$this->adminid);
        if($res['code'] == 0){
            return Json::error($res['msg']);
        }
        return Json::success($res['msg']);
    }

    public function saveothersetting(Request $request){
        $userid = $this->uid;
        $res = (new TaxService())->saveothersetting($request,$userid);
        if($res['code'] == 0){
            return Json::error($res['msg']);
        }
        return Json::success($res['msg']);
    }

    public function templates(Request $request){
        $userid = $this->uid;
        (new TaxService())->templates($request,$userid);
        return view('common.tax.templates');
    }

    public function template(Request $request){
        $userid = $this->uid;
        (new TaxService())->template($request,$userid);
        return view('common.tax.template');
    }

    public function saveTemplate(Request $request){
        $userid = $this->uid;
        $res = (new TaxService())->saveTemplate($request,$userid);
        if($res['code'] == 0){
            return Json::error($res['msg']);
        }
        return Json::success($res['msg']);
    }

    public function delTemplate(Request $request){
        $userid = $this->uid;
        $res = (new TaxService())->delTemplate($request,$userid);
        if($res['code'] == 0){
            return Json::error($res['msg']);
        }
        return Json::success($res['msg']);
    }

    public function yijiansetting(Request $request){
        $userid = $this->uid;
        $res = (new TaxService())->yijiansetting($request,$userid);
        if($res['code'] == 0){
            return Json::error($res['msg']);
        }
        return Json::success($res['msg']);
    }
}

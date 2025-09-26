<?php

namespace App\ort\services;

use App\Models\Game\Game;
use App\Models\Game\Play;
use App\Models\Game\User;
use App\ort\common\ComFunc;
use App\ort\common\CsFunc;
use App\ort\sgwin\SGUtils;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrdersExport implements FromView, ShouldAutoSize
{
    private $game;

    public function __construct($game)
    {
        $this->game = $game;
    }

    public function view(): View{
        $gid = isset($this->game['gid']) ? $this->game['gid'] : '';
        $qishu = isset($this->game['qishu']) ? $this->game['qishu'] : '';
        $tb_lib = isset($this->game['tb_lib']) ? $this->game['tb_lib'] : '';
        $start = isset($this->game['start']) ? $this->game['start'] : '';
        $end = isset($this->game['end']) ? $this->game['end'] : '';
        $db = Db::connection();
        if(empty($tb_lib)){
            $tb_lib = SGUtils::getcuretable(true);
        }
        $gstr = " 1=1 ";
        if(!empty($gid)){
            $gstr .= " and gid='$gid' ";
        }
        if(!empty($qishu)){
            $gstr .= " and qishu='$qishu' ";
        }
        if(!empty($start)){
            $gstr .= " and time>='$start' ";
        }
        if(!empty($end)){
            $gstr .= " and time<='$end' ";
        }
        $join = " from `$tb_lib` where $gstr";
        $sql = "select * $join order by id desc";
        $list = $db->select($sql);
        $i = 0;$bao = [];$tmp = [];
        foreach ($list as $item) {
            if (!isset($tmp['g' . $item['gid']])) {
                $game = Game::where('gid',$item['gid'])->select(['gname','fenlei'])->first();
                $tmp['g' . $item['gid']] = $game['gname'];
                $tmp['f' . $item['gid']] = $game['fenlei'];
            }
            if (!isset($tmp['u' . $item['userid']])) {
                $tmp['u' . $item['userid']] = User::where('userid',$item['userid'])->value('username');
            }
            if (!isset($tmp['b' . $item['gid'] . $item['bid']])) {
                $tmp['b' . $item['gid'] . $item['bid']] = CsFunc::transb8('name', $item['bid'], $item['gid']);
            }
            if (!isset($tmp['s' . $item['gid'] . $item['sid']])) {
                $tmp['s' . $item['gid'] . $item['sid']] = CsFunc::transs8('name', $item['sid'], $item['gid']);
            }
            if (!isset($tmp['c' . $item['gid'] . $item['cid']])) {
                $tmp['c' . $item['gid'] . $item['cid']] = CsFunc::transc8('name', $item['cid'], $item['gid']);
            }
            if (!isset($tmp['p' . $item['gid'] . $item['pid']])) {
                $tmp['p' . $item['gid'] . $item['pid']] = CsFunc::transp8('name', $item['pid'], $item['gid']);
            }
            $bao[$i]['code'] = $item['code'];
            $bao[$i]['time'] = date('Y-m-d H:i:s', $item['time']);
            $bao[$i]['week'] = ComFunc::rweek(date("w", $item['time']));
            $bao[$i]['game'] = $tmp['g' . $item['gid']];
            $bao[$i]['user'] = $tmp['u' . $item['userid']];
            $bao[$i]['qishu'] = $item['qishu'];
            $bao[$i]['abcd'] = $item['abcd'];
            $bao[$i]['wf'] = ComFunc::wfuser($tmp['f' . $item['gid']], $tmp['b' . $item['gid'] . $item['bid']], $tmp['s' . $item['gid'] . $item['sid']], $tmp['c' . $item['gid'] . $item['cid']], $tmp['p' . $item['gid'] . $item['pid']]);
            $bao[$i]['peilv1'] = $item['peilv1'];
            $bao[$i]['peilv2'] = $item['peilv2'];
            $bao[$i]['je'] = Comfunc::pr1($item['je']);
            $bao[$i]['points'] = $item['points'];
            $bao[$i]['xtype'] = ComFunc::transxtype($item['xtype']);
            $bao[$i]['z'] = $item['z'];
            if ($item['z'] == 1) {
                $bao[$i]['rs'] = Comfunc::pr1($item['peilv1'] * $item['je'] - $item['je'] * (1 - $item['points'] / 100));
            } else if ($item['z'] == 3) {
                $bao[$i]['rs'] = Comfunc::pr1($item['peilv2'] * $item['je'] - $item['je'] * (1 - $item['points'] / 100));
            } else if ($item['z'] == 2 || $item['z'] == 7) {
                $bao[$i]['rs'] = 0;
            } else if ($item['z'] == 5) {
                $bao[$i]['rs'] = Comfunc::pr1($item['prize'] - $item['je'] + $item['je'] * $item['points'] / 100);
            } else {
                $bao[$i]['rs'] = Comfunc::pr1(0 - $item['je'] * (1 - $item['points'] / 100));
            }
            $bao[$i]['con'] = $item['content'];
            $bao[$i]['rs'] = ComFunc::pr1($bao[$i]['rs']);
            $i++;
        }

        return view('common.exports.orders',['orders'=>$bao]);
    }
}

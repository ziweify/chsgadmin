<?php
/*
 * @Author: error: error: git config user.name & please set dead value or install git && error: git config user.email & please set dead value or install git & please set dead value or install git
 * @Date: 2024-09-27 08:21:49
 * @LastEditors: error: error: git config user.name & please set dead value or install git && error: git config user.email & please set dead value or install git & please set dead value or install git
 * @LastEditTime: 2024-09-30 02:35:08
 * @FilePath: /xyp_chsg/app/Http/Controllers/Manage/TestlxController.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

namespace App\Http\Controllers\Manage;

use App\ComServices\CmdBingo;
use App\ComServices\CmdPk;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestlxController extends Controller
{
    public function send(Request $request)
    {
        $msg = $request->input('msg', '');
        $game = $request->input('game', 'jssc');
        $amount_suoha = $request->input('amount', 10);
        if($game == 'jssc')
        {
            
            $pk = new CmdPk();
            $result = $pk->commandBetting($msg, $amount_suoha, true);
            return $result;
        }
        else if($game == 'twbg')
        {
            $pk = new CmdBingo();
            $result = $pk->commandBetting($msg, $amount_suoha, true);
            return $result;
        }
        else
        {
            return '未知的游戏';
        }
    }
}

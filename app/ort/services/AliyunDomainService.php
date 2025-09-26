<?php

namespace App\ort\services;

use AlibabaCloud\Alidns\Alidns;
use AlibabaCloud\Client\AlibabaCloud;
use App\Models\CustomDomain;
use Exception;

class AliyunDomainService
{

    public static function addrecord($domainlist,$ip){
        $accessKeyId = x_config('access_key_id');
        $accessKeySecret = x_config('access_key_secret');
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)->regionId('cn-hongkong')->asDefaultClient();
        $msg = '';
        foreach ($domainlist as $do){
            $domain = $do['domain'];
            //将域名前缀和主域名分开
            $domain_arr = explode('.',$domain);
            $record = $domain_arr[0];
            unset($domain_arr[0]);
            $domain = implode('.',$domain_arr);
            //添加解析记录
            try {
                $result = Alidns::v20150109()->addDomainRecord()
                    ->withDomainName($domain)
                    ->withRR($record)
                    ->withType('A')
                    ->withValue($ip)
                    ->withTTL('600')
                    ->request();
                if($result['RecordId']){
                    $msg .= $do['domain'].'添加成功<br>';
                    //更新记录id
                    CustomDomain::where('id',$do['id'])->update(['record_id'=>$result['RecordId']]);
                }else{
                    $msg .= $do['domain'].'添加失败<br>';
                }
            }catch (Exception $e) {
                //如果包含but it already exists表示已存在
                if(strpos($e->getMessage(),'The DNS record already exists') !== false){
                    $msg .= $do['domain'].'域名已存在<br>';
                }else{
                    $msg .= $do['domain'].'添加失败<br>';
                }
            }
        }
        return ['code'=>1,'msg'=>$msg];
    }


    public static function deleteDomain($domainlist){
        $accessKeyId = x_config('access_key_id');
        $accessKeySecret = x_config('access_key_secret');
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)->regionId('cn-hongkong')->asDefaultClient();
        $msg = '';
        foreach ($domainlist as $do){
            $record_id = $do['record_id'];
            //删除解析记录
            try {
                $result = Alidns::v20150109()->deleteDomainRecord()
                    ->withRecordId($record_id)
                    ->request();
                if($result['RecordId']){
                    $msg .= $do['domain'].'删除成功<br>';
                }else{
                    $msg .= $do['domain'].'删除失败<br>';
                }
            }catch (Exception $e) {
                //如果包含but it already exists表示已存在
                if(strpos($e->getMessage(),'The DNS record already exists') !== false){
                    $msg .= $do['domain'].'域名已存在<br>';
                }else{
                    $msg .= $do['domain'].'删除失败<br>';
                }
            }
        }
        return ['code'=>1,'msg'=>$msg];
    }

    public static function updaterecord($domain,$ip,$record_id){
        $accessKeyId = x_config('access_key_id');
        $accessKeySecret = x_config('access_key_secret');
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)->regionId('cn-hongkong')->asDefaultClient();
        //将域名前缀和主域名分开
        $domain_arr = explode('.',$domain);
        $record = $domain_arr[0];
        //修改解析记录
        try {
            $result = Alidns::v20150109()->updateDomainRecord()
                ->withRecordId($record_id)
                ->withRR($record)
                ->withType('A')
                ->withValue($ip)
                ->withTTL('600')
                ->request();
            if($result['RecordId']){
                return ['code'=>1,'msg'=>'修改域名成功'];
            }else{
                return ['code'=>0,'msg'=>'修改域名失败'];
            }
        }catch (Exception $e) {
            //如果包含but it already exists表示已存在
            if(strpos($e->getMessage(),'The DNS record already exists') !== false){
                return ['code'=>0,'msg'=>'域名已存在'];
            }else{
                return ['code'=>0,'msg'=>'修改域名失败'];
            }
        }
    }

    //检测记录是否存在
    public static function checkrecord($domain){
        $accessKeyId = x_config('access_key_id');
        $accessKeySecret = x_config('access_key_secret');
        AlibabaCloud::accessKeyClient($accessKeyId, $accessKeySecret)->regionId('cn-hongkong')->asDefaultClient();
        //将域名前缀和主域名分开
        $domain_arr = explode('.',$domain);
        $record = $domain_arr[0];
        unset($domain_arr[0]);
        $domain = implode('.',$domain_arr);
        //修改解析记录
        try {
            $result = Alidns::v20150109()->describeDomainRecords()
                ->withDomainName($domain)
                ->request();
            $records = $result['DomainRecords']['Record'];
            foreach ($records as $item){
                if($item['RR'] == $record){
                    return ['code'=>1,'msg'=>'域名已存在'];
                }
            }
            return ['code'=>0,'msg'=>'域名不存在'];
        }catch (Exception $e) {
            return ['code'=>0,'msg'=>'服务异常'];
        }
    }
}

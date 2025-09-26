<?php

namespace App\ort\services;

//用于aws域名解析
use Aws\Route53\Route53Client;
use Illuminate\Support\Facades\Cache;

class AwsDomainService
{

    private static $client = null;

    public static function getclient(){
        if(self::$client == null){
            self::$client = new Route53Client([
                'version' => 'latest',
                'region' => 'ap-east-1', // 根据你的需求选择区域
                'credentials' => [
                    'key' => x_config('access_key_id'), // 替换为你的 Access Key ID
                    'secret' => x_config('access_key_secret'), // 替换为你的 Secret Access Key
                ],
                'http' => [
                    'verify' => false, // 禁用 SSL 验证
                ],
            ]);
        }
        return self::$client;
    }

    public static function addDomain($domain,$ip){
        try {
            // 创建 Route 53 客户端实例
            $client = self::getclient();
            $hostedZoneId = self::getHostedZoneId($domain);
            $changes = [];
            $domainarr = explode(',',$domain);
            foreach ($domainarr as $item){
                $changes[] = [
                    'Action' => 'CREATE',
                    'ResourceRecordSet' => [
                        'Name' => $item,
                        'Type' => 'A',
                        'TTL' => 300, // 设置 TTL
                        'ResourceRecords' => [
                            [
                                'Value' => $ip, // 替换为你的 IP 地址
                            ],
                        ],
                    ],
                ];
            }
            // 设置 DNS 记录参数
            $recordParams = [
                'ChangeBatch' => [
                    'Changes' => $changes,
                    'Comment' => 'Add A record for '.$domain,
                ],
                'HostedZoneId' => $hostedZoneId, // 替换为你的 Hosted Zone ID
            ];
            // 发起 API 请求添加 DNS 记录
            $result = $client->changeResourceRecordSets($recordParams);
            // 输出结果
            if($result['@metadata']['statusCode'] == 200){
                return ['code'=>1,'msg'=>'添加域名成功'];
            }else{
                return ['code'=>0,'msg'=>'添加域名失败'];
            }
        }catch (\Exception $e) {
            //如果包含but it already exists表示已存在
            if(strpos($e->getMessage(),'but it already exists') !== false){
                return ['code'=>0,'msg'=>'域名已存在'];
            }else{
                return ['code'=>0,'msg'=>'添加域名失败'];
            }
        }
    }

    public static function deleteDomain($olddomain,$ip){
        try {
            // 创建 Route 53 客户端实例
            $client = self::getclient();
            $hostedZoneId = self::getHostedZoneId($olddomain);
            $changes = [];
            $domainarr = explode(',',$olddomain);
            foreach ($domainarr as $item){
                $changes[] = [
                    'Action' => 'DELETE',
                    'ResourceRecordSet' => [
                        'Name' => $item,
                        'Type' => 'A',
                        'TTL' => 300, // 设置 TTL
                        'ResourceRecords' => [
                            [
                                'Value' => $ip, // 替换为你的 IP 地址
                            ],
                        ],
                    ],
                ];
            }
            // 设置 DNS 记录参数
            $recordParams = [
                'ChangeBatch' => [
                    'Changes' => $changes,
                    'Comment' => 'Delete A record for '.$olddomain,
                ],
                'HostedZoneId' => $hostedZoneId, // 替换为你的 Hosted Zone ID
            ];
            // 发起 API 请求添加 DNS 记录
            $result = $client->changeResourceRecordSets($recordParams);
            if ($result['@metadata']['statusCode'] == 200) {
                return ['code' => 1, 'msg' => '删除域名成功'];
            } else {
                return ['code' => 0, 'msg' => '删除域名失败'];
            }
        }catch (\Exception $e) {
            //如果包含but it was not found表示不存在
            if(strpos($e->getMessage(),'but it was not found') !== false) {
                return ['code' =>1, 'msg' => '域名不存在，可以添加'];
            }
            return ['code'=>0,'msg'=>'删除域名失败'];
        }
    }

    public static function updateDomain($olddomain,$newdomain,$ip){
        //先删除原来的域名
        $result = self::deleteDomain($olddomain,$ip);
        if($result['code'] == 1){
            //再添加新的域名
            $result = self::addDomain($newdomain,$ip);
            if($result['code'] == 1) {
                return ['code'=>1,'msg' => '更新域名成功'];
            }else{
                return ['code'=>0,'msg'=>$result['msg']];
            }
        }else{
            return ['code'=>0,'msg'=>$result['msg']];
        }
    }


    public static function getHostedZoneId($domain){
        //如果是多个域名只取第一个
        $domainarr = explode(',',$domain);
        $domain = $domainarr[0];
        $dnsname = preg_replace('/^[^.]+\./', '', $domain, 1);
        $hostedZoneId = Cache::get('hid'.$dnsname);
        if(!empty($hostedZoneId)){
            return $hostedZoneId;
        }
        try {
            // 创建 Route 53 客户端实例
            $client = self::getclient();
            $result = $client->listHostedZonesByName([
                'DNSName' => $dnsname,
            ]);
            // 提取托管区域 ID
            if ($result['HostedZones']) {
                $hostedZoneId = $result['HostedZones'][0]['Id'];
                //去掉/hostedzone/
                $hostedZoneId = preg_replace('/\/hostedzone\//', '', $hostedZoneId, 1);
                Cache::put('hid'.$dnsname,$hostedZoneId);
                return $hostedZoneId;
            } else {
                return "";
            }
        }catch (\Exception $e) {
            return "";
        }
    }

    public static function getalldomain(){
        try {
            // 创建 Route 53 客户端实例
            $client = self::getclient();
            $result = $client->listHostedZones();
            return $result['HostedZones'];
        }catch (\Exception $e) {
            return [];
        }
    }

    public static function getrecordsbyhostedid($hostedZoneId){
        try {
            // 创建 Route 53 客户端实例
            $client = self::getclient();
            $result = $client->listResourceRecordSets([
                'HostedZoneId' => $hostedZoneId,
            ]);
            return $result['ResourceRecordSets'];
        }catch (\Exception $e) {
            return [];
        }
    }

    //修改解析记录
    public static function updateRecord($oldodmain,$newdomain,$recordValue,$oldrecordValue){
        try {
            // 创建 Route 53 客户端实例
            $client = self::getclient();
            $hostedZoneId = self::getHostedZoneId($oldodmain);
            // 设置 DNS 记录参数
            $recordParams = [
                'ChangeBatch' => [
                    'Changes' => [
                        [
                            'Action' => 'DELETE',
                            'ResourceRecordSet' => [
                                'Name' => $oldodmain,
                                'Type' => 'A',
                                'TTL' => 300, // 设置 TTL
                                'ResourceRecords' => [
                                    [
                                        'Value' => $oldrecordValue, // 替换为你的 IP 地址
                                    ],
                                ],
                            ],
                        ],
                        [
                            'Action' => 'CREATE',
                            'ResourceRecordSet' => [
                                'Name' => $newdomain,
                                'Type' => 'A',
                                'TTL' => 300, // 设置 TTL
                                'ResourceRecords' => [
                                    [
                                        'Value' => $recordValue, // 替换为你的 IP 地址
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'Comment' => 'Update '.$oldodmain.' record',
                ],
                'HostedZoneId' => $hostedZoneId, // 替换为你的 Hosted Zone ID
            ];
            // 发起 API 请求添加 DNS 记录
            $result = $client->changeResourceRecordSets($recordParams);
            // 输出结果
            if($result['@metadata']['statusCode'] == 200){
                return ['code'=>1,'msg'=>'修改解析记录成功'];
            }else{
                return ['code'=>0,'msg'=>'修改解析记录失败'];
            }
        }catch (\Exception $e) {
            //如果包含but it already exists
            if(strpos($e->getMessage(),'but it already exists') !== false) {
                return ['code'=>0,'msg'=>'解析记录已存在'];
            }
            //如果包含but it was not found表示不存在
            if(strpos($e->getMessage(),'but it was not found') !== false) {
                return ['code'=>0,'msg'=>'解析记录不存在'];
            }
            return ['code'=>0,'msg'=>'修改解析记录失败'];
        }
    }
}

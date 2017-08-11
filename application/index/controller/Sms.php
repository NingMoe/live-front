<?php
/**
 * Created by PhpStorm.
 * User: yuangong
 * Date: 2017/8/11
 * Time: 9:57
 */

namespace app\index\controller;


use think\Controller;
use think\Cache;
class Sms extends Controller
{
    const SMS_TIME = 60;//发送间隔时间
    const SMS_NUMBER = 5;//缓存有效期内发送短信的最大数


    public function getCode(){

            if(!$this->sendConfine()){
               $arr['status'] = 'error';
               $arr['msg']    = '同一设备发送需间隔60秒';
            }else{
                $mobile = input('post.uphone');
                if($this->sendSms($mobile)){
                    $arr['status'] = 'success';
                    $arr['msg']    = '发送成功';
                }else{
                    $arr['status'] = 'error';
                    $arr['msg']    = '发送失败,请稍后重试';
                }
            }
            return json_encode($arr);
    }

    protected function sendSms($mobile){

        date_default_timezone_set('Asia/Shanghai');
        $ip = get_client_ip(0,true);
        vendor('alidayu.TopSdk');
        $c = new \TopClient;
        $c->appkey = "23467398";//必填用户appkey
        $content = rand(1000,9999);
        session('sms',array('code'=>$content,'time'=>time()));
        $c->secretKey = "7c8f29c7c17e53e5e4bd8e46ba3dd3b6";//必填 用户secretKey
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        $req->setSmsType("normal");
        $req->setSmsFreeSignName("短信验证");
        $req->setSmsParam("{\"yanzheng\":\"".$content."\"}");//验证码和网站名字
        $req->setRecNum($mobile);
        $req->setSmsTemplateCode("SMS_46560082");//短息模板 由阿里大鱼用户提供认证通过才行
        $resp = $c->execute($req);
        if($resp->result->success){
            Cache::tag($ip)->set('number',1,3600);
            Cache::tag($ip)->set('send_time',time(),3600);
            return 1;
        }else{
            return -1;
        }

    }

    /**
     * 短信接口限制ip
     * @return boolean
     */

    protected function sendConfine(){
        //Cache::clear();return;
        $ip = get_client_ip(0,true);
        $check = Cache::tag($ip)->get('number');
        $flag = false;
        if(!$check){
            $flag = true;
        }else{
           $cur_time = time();
           $number = Cache::tag($ip)->get('numbe');
           $time =  Cache::tag($ip)->get('send_time');
           if($cur_time-$time>self::SMS_TIME && $number<self::SMS_NUMBER){
                $flag = true;
           }
        }
        return $flag;
    }

}
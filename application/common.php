<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\helper\Hash;

// 应用公共文件
if(!function_exists('is_login')){
    /**
     * 判断是否登录
     */
    function is_login(){
        return session('user')?true:false;
    }
}


if (!function_exists('get_client_ip')) {
    /**
     * 获取客户端IP地址
     * @param int $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param bool $adv 是否进行高级模式获取（有可能被伪装）
     * @return mixed
     */
    function get_client_ip($type = 0, $adv = false) {
        $type       =  $type ? 1 : 0;
        static $ip  =   NULL;
        if ($ip !== NULL) return $ip[$type];
        if($adv){
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos    =   array_search('unknown',$arr);
                if(false !== $pos) unset($arr[$pos]);
                $ip     =   trim($arr[0]);
            }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip     =   $_SERVER['HTTP_CLIENT_IP'];
            }elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip     =   $_SERVER['REMOTE_ADDR'];
            }
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u",ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }
}

if(!function_exists('userArray')){
    /**
     * 返回规定格式的用户信息数组
     * @return json
     */
    function userArray($nickname='',$level='',$head='',$levelname='',$uid=''){
        return array(
            'nickname'=>$nickname,
            'level'=>$level,
            'head'=>$head,
            'levelname'=>$levelname,
            'uid'=>$uid
        );
    }
}


if(!function_exists('setSession')){
    /**
     * 设置session
     * $arr 数组格式
     */
    function setSession($arr=null){
       if(empty($arr['profile'])){
           $id = time();
           session('user',array(
               'nickname'=>'游客'.$id,
               'level'=>1,
               'time'=>time(),
               'head'=>'/static/images/youke'.rand(0,5).'.png',
               'login_time'=>time(),
               'uname'=>$id,
               'profile'=>$arr,
               'login_ip'=>get_client_ip(0,true)
           ));
       }else{
           $arr['login_ip'] = get_client_ip(0,true);
           session('user',$arr);
       }
    }
}

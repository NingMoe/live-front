<?php
namespace app\index\controller;
use think\cache\driver\Redis;
use think\Controller;
use think\Session;
use GatewayClient\Gateway;
use app\push\controller\Worker;
class Front extends Common
{
   //封禁
    public function rid_of(){
        if(request()->isPost()){
            $cid = input('post.clientId');
            if(empty($cid)){
                return '{"type":"-1","msg":"用户cid为空"}';
            }

            $user = Gateway::getSession($cid);
            if(empty($user['login_ip'])){
                echo '{"type":"-1","msg":"踢出失败,无法获取此用户ip地址"}';
                return;
            }
            $ip = $user['login_ip'];
            $black = Model('Blacklist');
            $msg = $black->add($ip);
            $worker = new Worker();
            $worker->bannedUser($cid);
            return $msg;
        }
    }
}

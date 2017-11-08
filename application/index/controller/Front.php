<?php
namespace app\index\controller;
use think\cache\driver\Redis;
use think\Controller;
use think\Session;
use app\push\controller\Caches;
use app\push\controller\Worker;
class Front extends Common
{
   //封禁
    public function rid_of(){
        if(request()->isPost()){
            $cid = input('post.clientId');
            if(empty($cid)){
                return '用户cid为空';
            }
            $user = json_decode(Caches::getUser($cid),true);
            $ip = $user['login_ip'];
            $black = Model('Blacklist');
            $msg = $black->add($ip);
            $worker = new Worker();
            $worker->bannedUser($cid);
            return $msg;
        }
    }
}

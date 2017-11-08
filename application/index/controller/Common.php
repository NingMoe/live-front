<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;

class Common extends Controller
{
    //判断黑名单用户
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $ip = get_client_ip(0,true);
        $ip = explode('.',$ip);
        $ip = $ip[0].'.'.$ip[1].'.'.$ip[2];
        $black = Model('blacklist')->getIp($ip);

        if(!empty($black)){
           $this->redirect("/index/Error/index");
        }

    }
}

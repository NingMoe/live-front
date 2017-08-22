<?php
namespace app\index\controller;
use think\Controller;
class Index extends Controller
{
    public function index()
    {
        if(!empty(session('user')) && session('user.level')>=7){
            //查询当前职员机器人角色
            $jiqi = model('yiqiu/Jiqiren');
            $role = $jiqi->getRole(session('user.id'));
            $this->assign('role',$role);
        }
        return view('index',[
            'user'=>session('user')
        ]);
    }

    public function face(){
        return view();
    }

    public function getUserInfo(){
        if(!is_login()){
            $id = rand(10000000,99999999);
            //未登录 返回游客信息
            $user = userArray('游客'.$id,0,'/static/images/youke'.rand(0,5).'.png','游客',$id);
        }else{
            $user = userArray(session('user.nickname'),session('user.level'),session('user.head'),session('user.profile.name'),session('user.uname'));
        }
        return json_encode($user);
    }
}

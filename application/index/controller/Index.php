<?php
namespace app\index\controller;
use think\Controller;
class Index extends Controller
{
    public function index()
    {
        return view('index',[
            'user'=>session('user')
        ]);
    }

    public function face(){
        return view();
    }

    public function getUserInfo(){
        if(!is_login()){
            //未登录 返回游客信息
            $user = userArray('游客'.rand(10000000,99999999),0,'/static/images/youke'.rand(0,5).'.png','游客');
        }else{
            $user = userArray(session('user.nickname'),session('user.level'),session('user.head'),session('user.profile.name'));
        }
        return json_encode($user);
    }
}

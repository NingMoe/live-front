<?php
namespace app\index\controller;
use GatewayClient\Gateway;
use think\Controller;
use app\index\Model\Jiqiren;
use think\Session;
use app\push\controller\Caches;
class Index extends Common
{
    public function index()
    {
        //初始化session
        $user = $this->getUserInfo();
        unset($user['group']['check_setup']);//删除设置权限字段 否则前端报错
        unset($user['upwd']);//删除密码字段

        //判断是否手机端访问
        if(request()->isMobile()){
            $this->redirect('index/index/mobile');
            return;
        }

        //查询当前用户机器人
        $role = '';
        if(session('user.level')>=7){
            $jiqiren = new Jiqiren();
            $role = $jiqiren->getRole(session('user.uname'));
        }
       //dump($user); dump($role);exit;

        //查询banner图
        $banner = model('Banner');
        $banner = $banner->getinfo();
        foreach($banner as $key=>$val){
            $banner[$key] = $val->toArray();
        }

        //查询当前用户设置权限
        $id_arr = json_decode(session('user.group')['check_setup'],true);
        $set = model('Setupmenu');
        if($set = $set->getTopList($id_arr)){
            foreach($set as $key=>$val){
                $set[$key] = $val->toArray();
                if($set[$key]['is_front']!=1){//如果不需要前台显示 删除数据
                    unset($set[$key]);
                }
            }
        }else{
            $set = '';
        }

        //查询房间基本信息
        $roominfo = model('Roominfo')->getroom();

        return view('index',[
            'user'=>$user,
            'userinfo'=>json_encode($user),
            'role'=>$role,
            'banner'=>$banner,
            'set'=>$set,
            'roominfo'=>$roominfo
        ]);
    }

    public function face(){
        return view();
    }

    public function getUserInfo(){
        //刷新用户状态
        if(session('user.level')>1){
            $user = model('User');
            $result = $user->saveUserStatus(session('user'));
            if(!$result){
                return '刷新用户状态失败...';
            }
        }else{
            //如果游客状态session不为空,直接return
            if(!empty(session('user.profile'))){
                return session('user');
            }
            //查询游客等级信息
            $level = model('Level');
            $level = $level->getLevel(1);
            setSession($level);
        }
        return session('user');
    }

    //QQ客服
    public function qq(){
        $qq_arr = model('Qq')->getqq()->toArray();
        $qq_arr = explode('*',$qq_arr['qq']);
        $key = array_rand($qq_arr);
        $qq = trim($qq_arr[$key]);
        echo $qq;
    }

    //获取在线人数
    public function get_number(){
        sleep(2);
        if(session('user.profile')['level']>=10){
            $data['type'] = 'success';
            $data['number'] = Gateway::getClientCountByGroup('7000');
        }else{
            $data['type'] = 'error';
            $data['msg']  = '你没有权限获取.';
        }
        return json_encode($data);
    }

    //查询最近的50条发言
    public function message(){
        $where = '';
        if(empty(session('user.group')) || session('user.group')['check_msg']==1){
            $where = ['is_check'=>0];
        }

        $data = model('Chatcontents')->get_contents($where);
        $data = collection($data)->toArray();
        return json_encode($data);
    }

    public function mobile(){

        return view('mobile',[
            'user'=>session('user')
        ]);
    }
}


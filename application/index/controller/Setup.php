<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Session;
use app\push\controller\Caches;
use app\push\controller\Worker;
class Setup extends Common
{
    //构造方法判断用户是否有权限
    public function __construct(Request $request = null)
    {
        //当前访问地址
        $request = \request()->module().'/'.\request()->controller().'/'.\request()->action();

        //查询菜单列表
        $menu = model('Setupmenu');
        $menu = $menu->getlist();
        $menu_arr = [];
        foreach($menu as $val){
            array_push($menu_arr,$val->toArray());
        }

        $group = json_decode(session('user.group')['check_setup'],true);
        if(!$group){
            exit;
        }
        $flag = false;
        foreach($menu_arr as $val){
            if(strtolower($val['link'])==strtolower($request)){
                if(in_array($val['menu_id'],$group)){
                    $flag = true;
                }
            }
        }

        if(!$flag){
            echo '你没有权限进行此项操作';
            exit;
        }

    }

    //房间基本信息
     public function index(){

        if(\request()->isPost()){
            $data = input('post.');
            $data['room_bg'] = str_replace('\\','/',$data['room_bg']);
            unset($data['file']);
            $setup = model('roominfo');
            if($setup->add($data)){
                echo "<script>history.go(-1);</script>";
            }else{
                echo '修改失败';
            }
        }else{
            //查询房间信息
            $room = model('Roominfo');
            $room = $room->getroom()->toArray();
            return view('index',array(
                'room'=>$room
            ));
        }
     }

     //轮播图
     public function banner(){
         if(\request()->isPost()){
            $data = input('post.');
            unset($data['file']);
             $banner = model('Banner');
             if($banner->add($data)){
                 echo "<script>history.go(-1);</script>";
             }else{
                 echo '添加失败';
             }

         }else{
             $banner = model('Banner');
             $banner = $banner->getinfo();
             foreach($banner as $key=>$val){
                 $banner[$key] = $val->toArray();
             }
             return view('banner',array(
                 'banner'=>$banner
             ));
         }
     }

     //轮播图删除
     public function banner_del(){
         $id = input('post.id');
         $banner = model('Banner');
         $banner->del($id);
         return $banner;
     }

     //弹幕飞屏
    public function danmu(){
         if(\request()->isPost()){
             $data = input('post.');
             $worker = new Worker();
             $worker->sendDanmu($data);
             echo '发布成功';
         }else{
             return view('danmu');
         }
    }


    //QQ客服
    public function qq(){
        if(\request()->isPost()){
            $qq = input('post.');
            $model = model('Qq')->add($qq);
            if($model){
               echo '修改成功';
            }else{
                echo '修改失败 ps:修改后的数据和原数据一致 将会更新失败';
            }
        }else{
            $data = model('Qq')->getqq()->toArray();
            return view('qq',array(
                'data'=>$data
            ));
        }
    }
}

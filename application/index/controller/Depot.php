<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use app\push\controller\Caches;
use app\index\controller\Setup;
use app\push\controller\Worker;
class Depot extends Setup
{
    //产品类型
    public $type = array('现价买入','现价卖出','采购做多','销售做空');
    //产品类型
    public $maidan = array('麦上单','麦下单');
    //建仓显示条数
    public $jcCount = 15;

    //构造方法判断用户是否有权限
    public function __construct()
    {
        parent::__construct();
    }

    public function jiancang_add(){
        if(\request()->isPost()){
            $data = input('post.');
            $goods_name = $data['goods_name'];
            unset($data['goods_name']);
            $depot = model('Depot');
            if($depot->add($data)){
                //建仓成功 推送建仓消息
                $worker = new Worker();
                $worker->sendDepot('建仓提醒',session('user.nickname'),$goods_name,'/index/Depot/jiancang');
                $this->redirect('Depot/jiancang');
            }else{
                echo '建仓失败(数据库添加失败)';
            }
        }else{
            //查询产品
            $goods = model('Goods');
            $goods = $goods->goods_info();
            foreach($goods as $key=>$val){
                $goods[$key] = $val->toArray();
            }

            return view('jiancang_add',array(
                'type'=>$this->type,
                'maidan'=>$this->maidan,
                'goods'=>$goods
            ));
        }
    }

    public function jiancang(){

        //查询商品数据
        $goods = model('Goods');
        $goods = $goods->goods_info();
        foreach($goods as $key=>$val){
            $goods[$key] = $val->toArray();
        }

        //获取老师数据
        $user = model('user')->teacherInfo();
        foreach($user as $key=>$val){
            $user[$key] = $val->toArray();
        }

        //查询是否有修改或删除权限 隐藏前台按钮
        $edit_url = 'index/Depot/jiancang_edit';//修改地址
        $del_url  = 'index/Depot/jiancang_delete';//删除地址
        $pj_url   = 'index/Depot/pingcang_add'; //平仓地址

        //查询菜单列表
        $menu = model('Setupmenu');
        $menu = $menu->getlist();
        $menu_arr = [];
        foreach($menu as $val){
            array_push($menu_arr,$val->toArray());
        }

        //当前用户组信息
        $group = json_decode(session('user.group')['check_setup'],true);

       //循环
        $edit_btn = false;
        $del_btn  = false;
        $pj_btn   = false;
        foreach($menu_arr as $val){
            if(in_array($val['menu_id'],$group)){
                if(strtolower($val['link'])==strtolower($edit_url)){
                    $edit_btn = true;
                }else if(strtolower($val['link'])==strtolower($del_url)){
                    $del_btn = true;
                }else if(strtolower($val['link'])==strtolower($pj_url)){
                    $pj_btn   = true;
                }
            }
        }

        return view('jiancang',array(
            'goods'=>$goods,
            'teacher'=>$user,
            'jcCount'=>$this->jcCount,
            'edit'=>$edit_btn,
            'del'=>$del_btn,
            'pj'=>$pj_btn
        ));

    }

    public function jiancang_delete(){
        $id = input('post.id');
        $jc = model('Depot');
        if($jc->del($id)){
            $data['type'] = 'success';
        }else{
            $data['type'] = 'error';
            $data['msg'] = '删除失败';
        }
        echo json_encode($data);
    }

    public function jiancang_edit(){
        if(\request()->isPost()){
            $data = input('post.');
            $jc = model('Depot');
            if($jc->saveJc($data)){
                $this->redirect('Depot/jiancang');
            }else{
                echo '修改失败';
            }
        }else{

            $id = input('get.id');
            $jc = model('Depot');
            $data = $jc->getIdInfo($id)->toArray();

            //查询产品
            $goods = model('Goods');
            $goods = $goods->goods_info();
            foreach($goods as $key=>$val){
                $goods[$key] = $val->toArray();
            }

            return view('jiancang_edit',array(
                'type'=>$this->type,
                'maidan'=>$this->maidan,
                'goods'=>$goods,
                'data'=>$data,
                'id'=>$id
            ));
        }
    }

    public function jiancangInfo($where=''){

        $judge = input('param.');//获取查询表达式

        //构造时间查询格式
        $time = [];
        empty($judge['beginDate'])?'':array_push($time,array('egt',strtotime($judge['beginDate'])));
        empty($judge['endDate'])?'':array_push($time,array('elt',strtotime($judge['endDate'])));
        //如果是两个时间条件添加连接符
        if(!empty($time[0]) && !empty($time[1])){
            $time[2] = 'AND';
        }else{
            //如果是一个时间条件
            if(!empty($time)){
                $time = $time[0];
            }
        }
        //删除空数组
        $time = array_filter($time);

        //查询表达式数组 前面d参考模型alias简写 不然会报错
        $where['d.create_time'] = empty($time)?'':$time;
        $where['d.uid'] = empty($judge['uid'])?'':$judge['uid'];
        $where['d.goods_id'] = empty($judge['goods_id'])?'':$judge['goods_id'];
        $where['d.depot_type'] = empty($judge['depot_type'])?'':$judge['depot_type'];

        //删除空数组
        $where = array_filter($where);

        $limit = ((int)$judge['page']-1)*$this->jcCount.','.$this->jcCount;//分页

        $jc = model('Depot');
        $info = $jc->jiancang($where,$limit);
        foreach($info as $key=>$val){
            $info[$key] = $val->toArray();
            if(!empty($info[$key]['end_time'])){
                $info[$key]['end_time'] = date('Y-m-d H:i:s',$info[$key]['end_time']);
            }
        }

        $data['code']=0;
        $data['msg']='';
        //查询总记录数
        $data['count']=$jc->jcCount($where);
        $data['data']=$info;
        echo json_encode($data);
    }

    public function pingcang(){
        //查询商品数据
        $goods = model('Goods');
        $goods = $goods->goods_info();
        foreach($goods as $key=>$val){
            $goods[$key] = $val->toArray();
        }

        //获取老师数据
        $user = model('user')->teacherInfo();
        foreach($user as $key=>$val){
            $user[$key] = $val->toArray();
        }

        //查询是否有修改或删除权限 隐藏前台按钮
        $edit_url = 'index/Depot/jiancang_edit';//修改地址
        $del_url  = 'index/Depot/jiancang_delete';//删除地址

        //查询菜单列表
        $menu = model('Setupmenu');
        $menu = $menu->getlist();
        $menu_arr = [];
        foreach($menu as $val){
            array_push($menu_arr,$val->toArray());
        }

        //当前用户组信息
        $group = json_decode(session('user.group')['check_setup'],true);

        //循环
        $edit_btn = false;
        $del_btn  = false;
        foreach($menu_arr as $val){
            if(in_array($val['menu_id'],$group)){
                if(strtolower($val['link'])==strtolower($edit_url)){
                    $edit_btn = true;
                }else if(strtolower($val['link'])==strtolower($del_url)){
                    $del_btn = true;
                }
            }
        }

        return view('pingcang',array(
            'goods'=>$goods,
            'teacher'=>$user,
            'jcCount'=>$this->jcCount,
            'edit'=>$edit_btn,
            'del'=>$del_btn,
        ));
    }


    public function pingcang_add(){
        if(\request()->isPost()){
            $data = input('post.');
            $data['end_time'] = time();
            $data['depot_type'] = 2;
            $goods_name = input('post.goods_name');
            unset($data['goods_name']);
            $jc = model('Depot');
            if($jc->saveJc($data)){
                //建仓成功 推送建仓消息
                $worker = new Worker();
                $worker->sendDepot('平仓提醒',session('user.nickname'),$goods_name,'/index/Depot/pingcang');
                $this->redirect('Depot/pingcang');
            }else{
                echo '平仓失败';
            }
        }else{
            $id = input('get.id');
            $goods_name = input('get.goods_name');
            if(empty($id) || empty($goods_name)){
                echo '无效的访问,';
                exit;
            }
            return view('pingcang_add',array(
                'id'=>$id,
                'goods_name'=>$goods_name
            ));
        }
    }
}

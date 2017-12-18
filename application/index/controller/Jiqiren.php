<?php
/**
 * Created by PhpStorm.
 * User: yuangong
 * Date: 2017/8/18
 * Time: 15:40
 */

namespace app\index\controller;
use think\Controller;
use think\View;

class Jiqiren extends Common
{
    public function index(){
        $jiqi = model('Jiqiren');
        $role = $jiqi->getRole(session('user.uname'));
        return view('',[
            'role'=>$role
        ]);
    }
    public function add(){
		if($_POST){
			$data = [
			    'name'=>input('post.name'),
                'level'=>input('post.level'),
                'uid'=>session('user.uname')
            ];

			if(session('user.level')<7){
                $arr['status'] = 'error';
                $arr['msg']  = '你没有权限';
            }else{
			    $jiqi = model('Jiqiren');
			    $result = $jiqi->add($data);
			    if($result=='success'){
			        $arr['status'] = $result;
                }else{
			        $arr['status'] = 'error';
			        $arr['msg']    = $result;
                }
            }
            return json_encode($arr);
		}else{

			$level = model('Level');
            $data  = $level->getLevelAll(1);
			return view('',[
			    'level'=>$data
            ]);
		}
	}

	public function del($id){

        $id = input('post.id');
        $jiqi = model('Jiqiren');
        if($jiqi->del($id)){
            $data['status'] = 'success';
        }else{
            $data['status'] = 'error';
            $data['msg']    = '删除失败';
        }
        return json_encode($data);
    }
}
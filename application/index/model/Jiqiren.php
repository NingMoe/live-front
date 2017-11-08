<?php
/**
 * Created by PhpStorm.
 * User: yuangong
 * Date: 2017/8/21
 * Time: 15:06
 */

namespace app\index\model;
use think\Collection;
use think\Model;
use think\validate;
class Jiqiren extends Model
{


    public function add($data){

        $jiqi = new Jiqiren($data);

        $res = $jiqi->where('name',$data['name'])->find();
        if(!empty($res)){
            return '姓名已存在';
        }
        if($jiqi->save()){
            return 'success';
        }else{
            return '数据添加失败';
        }

    }

    public function getRole($uid){
       $role = Jiqiren::All(['uid'=>$uid]);
       $role = collection($role)->toArray();
       return $role;
    }

    function del($id){
        // 删除状态为0的数据
        $flag = Jiqiren::destroy($id);
        return $flag;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: yuangong
 * Date: 2017/8/21
 * Time: 15:06
 */

namespace app\yiqiu\model;
use think\Collection;
use think\Model;
use think\validate;
class Jiqiren extends Model
{
    protected $rule = [
        'name'=>'require',
        'level'=>'require',
        'level_name'=>'require',
        'uid'=>'require'
    ];

    protected $msg = [
        'name.require'=>'姓名必须',
        'level.require'=>'等级必须',
        'level_name.require'=>'等级名称必须',
        'uid.require'=>'uid必须'
    ];

    public function add($data){
        $validate = new Validate($this->rule,$this->msg);
        $result = $validate->check($data);
        if($result){
            $jiqi = new Jiqiren($data);
            $res = $jiqi->where('name',$data['name'])->find();
            if(!empty($res)){
                return '姓名已存在';
            }
            if($a = $jiqi->save()){
                return 'success';
            }else{
                return '数据添加失败';
            }
        }else{
            return $validate->getError();
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
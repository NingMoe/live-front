<?php
/**
 * Created by PhpStorm.
 * User: yuangong
 * Date: 2017/8/18
 * Time: 9:59
 */

namespace app\index\model;
use think\Model;

class Level extends Model
{
    public function getLevel($level){
        return Level::get(['level'=>$level])->toArray();
    }

    //获取指定类型等级
    public function getLevelAll($type){
       $level =  Level::all(['group_id'=>$type]);
       $level = collection($level)->toArray();
       return $level;
    }

    //获取用户组
    public function getGroup($level){
        $le = Level::get(['id'=>$level],'profile');
        if(empty($le)){
            return '查询不到当前用户组';
        }
        return $le->profile->data;
    }

    //获取指定组id的等级信息
    public function getGroupId($id){
        //如果查询数据为空 会报错
        return Level::get(['group_id'=>$id])->toArray();
    }

    //关联查找
    public function profile()
    {
        return $this->hasOne('Group','group_id','group_id');
    }
}
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
       $level =  Level::all(['type'=>$type]);
       $level = collection($level)->toArray();
       return $level;
    }
}
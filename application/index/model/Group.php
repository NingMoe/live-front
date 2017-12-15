<?php
/**
 * Created by PhpStorm.
 * User: yuangong
 * Date: 2017/8/18
 * Time: 9:59
 */

namespace app\index\model;
use think\Model;

class Group extends Model
{
    public function getGroup($id){
        return Group::get(['id'=>$id])->toArray();
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: yuangong
 * Date: 2017/8/18
 * Time: 9:59
 */

namespace app\index\model;
use think\Model;

class Blacklist extends Model
{
   public function add($data){
       if(!empty(Blacklist::get(['ip'=>$data['ip']]))){
           return '该ip已在黑名单内';
       }
       if(empty($data['over_time'])){
           $data['over_time'] = time()+60*60*24*360;
       }
       if(Blacklist::save($data)){
           return '添加黑名单成功';
       }

       return '添加黑名单失败';

   }

   //模糊查找
    public function getIp($ip){
       return Blacklist::whereLike('ip','%'.$ip.'%')->find();
    }
}
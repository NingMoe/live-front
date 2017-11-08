<?php
/**
 * Created by PhpStorm.
 * User: yuangong
 * Date: 2017/8/18
 * Time: 9:59
 */

namespace app\index\model;
use think\Model;
use app\push\controller\Caches;
class Roominfo extends Model
{
   public function getroom(){
       return Roominfo::get(1);
   }

   public function add($data){
       return Roominfo::where('id',1)->update($data);
   }

   public function gettitle(){
       return Roominfo::where('id',1)->field('room_name')->find();
   }
}
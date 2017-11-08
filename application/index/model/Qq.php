<?php
/**
 * Created by PhpStorm.
 * User: yuangong
 * Date: 2017/8/18
 * Time: 9:59
 */

namespace app\index\model;
use think\Model;
class Qq extends Model
{
   public function add($data){
        return Qq::save($data,['id'=>1]);
   }

   public function getqq(){
       return Qq::get(1);
   }
}
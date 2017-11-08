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
class Setupmenu extends Model
{
   public function getlist(){
       return SetupMenu::all();
   }

   public function getTopList($id_arr){
       if(empty($id_arr)){
           return false;
       }
       return SetupMenu::all($id_arr);
   }

}
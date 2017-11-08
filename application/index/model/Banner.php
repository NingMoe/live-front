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
class Banner extends Model
{
   public function getinfo(){
       return Banner::all(function($query){
           $query->order('sort desc');
       });
   }

    public function del($id){
       return Banner::destroy($id);
    }

    public function add($data){
        return Banner::save($data);
    }
}
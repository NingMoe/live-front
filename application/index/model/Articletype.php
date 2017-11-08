<?php
/**
 * Created by PhpStorm.
 * User: yuangong
 * Date: 2017/8/18
 * Time: 9:59
 */

namespace app\index\model;
use think\Model;

class Articletype extends Model
{
    public function getall(){
        return Articletype::all();
    }

    public function gettype($id){
        return Articletype::get($id);
    }
}
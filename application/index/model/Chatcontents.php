<?php
/**
 * Created by PhpStorm.
 * User: yuangong
 * Date: 2017/8/18
 * Time: 9:59
 */

namespace app\index\model;
use think\Model;

class Chatcontents extends Model
{
    public function get_contents($where=''){

        return Chatcontents::all(function($query) use($where){
            $query->join('tp_level','tp_Chatcontents.level_id=tp_level.id')->where($where)->order('send_time desc')->limit(50);
        });

    }

    public function profile(){
        return $this->hasOne('level','id','level_id');
    }

}
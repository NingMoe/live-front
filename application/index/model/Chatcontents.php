<?php
/**
 * Created by PhpStorm.
 * User: yuangong
 * Date: 2017/8/18
 * Time: 17:48
 */

namespace app\index\model;
use think\Model;

class Chatcontents extends Model
{
    public function add($data){
        $msg = [
            'nickname'=>$data['nickname'],
            'message'=>$data['msg'],
            'send_time'=>time(),
            'send_type'=>$data['type'],
            'head'=>$data['head'],
            'level'=>$data['level']
        ];
        $chat = new Chatcontents($msg);
        $chat->save();
    }
}
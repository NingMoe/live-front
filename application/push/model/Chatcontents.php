<?php
/**
 * Created by PhpStorm.
 * User: yuangong
 * Date: 2017/8/18
 * Time: 17:48
 */

namespace app\push\model;
use think\Model;

class Chatcontents extends Model
{
    public function add($data){
        $msg = [
            'message'=>$data['msg'],
            'send_time'=>$data['time'],
            'is_check'=>$data['is_check'],
            'mid'=>$data['mid']
        ];
        $chat = new Chatcontents();
        $arr = $chat->where('mid',$msg['mid'])->find();
        if(empty($arr)){
            $result = $chat->save($msg);
        }else{
            $result = $chat->save($msg,['mid'=>$msg['mid']]);
        }
        return $result;
    }

    public function updateMsg($mid){
        $chat = new Chatcontents();
        $result = $chat->save(array('is_check'=>0,'send_time'=>time()),['mid'=>$mid]);
        return $result;
    }

    public function deleteMsg($mid){
        $chat = new Chatcontents();
        $result = $chat->where('mid',$mid)->delete();
        return $result;
    }
}
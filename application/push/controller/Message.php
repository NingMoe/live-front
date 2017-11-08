<?php
/**
 * Created by PhpStorm.
 * User: yuangong
 * Date: 2017/10/3
 * Time: 15:54
 */

namespace app\push\controller;
use think\Controller;
use \think\Cache;

class Message extends Cache
{
    const REDIS_STATUS = false;//是否使用redis缓存

    /**
     *保存发言
     * @param  Array $data
     * @return boolean
     */
    public static function saveMsg($data){
        if(!self::REDIS_STATUS){
            $chat = model('Chatcontents');
            $result = $chat->add($data);
            if(!$result){
                echo '发言保存失败...';
            }
        }else{

        }

    }

    /**
     *删除发言
     *@param $mid 消息ID
     */
    public static function deleteMsg($mid){
        if(!self::REDIS_STATUS){
            $chat = model('Chatcontents');
            $result = $chat->deleteMsg($mid);
            if(!$result){
                echo '删除发言失败...';
            }
        }else{

        }
    }


    public static function saveMsgStatus($mid){
        $msg = model('push/Chatcontents');
        if($msg->updateMsg($mid)){
            return true;
        }
        return false;
    }

}
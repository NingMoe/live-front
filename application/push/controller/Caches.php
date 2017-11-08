<?php
/**
 * Created by PhpStorm.
 * User: yuangong
 * Date: 2017/10/4
 * Time: 17:45
 */

namespace app\push\controller;
use think\Cache;

class Caches extends Cache
{
    const USER_LIST = 'user_list';//用户列表


    //保存用户列表
    public static function setUserList($user){
        return Cache::init()->handler()->Hset(self::USER_LIST,$user['clientId'],json_encode($user));
    }

    //将用户从用户列表删除
    public static function delUserToList($key){
        //dump(Caches::init()->handler()->HDEL(self::USER_LIST,$key));
    }

    //查找指定用户
    public static function getUser($cid){
        return Cache::init()->handler()->Hget(self::USER_LIST,$cid);
    }
}
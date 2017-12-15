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
    const KEFU_LIST = 'kefu_list';//客服列表


}
<?php
/**
 * Created by PhpStorm.
 * User: yuangong
 * Date: 2017/8/18
 * Time: 15:40
 */

namespace app\index\controller;
use think\Controller;
use think\Cache;
class Cachea extends Controller
{
    protected static $a = array();
    public function index(){
        self::$a['a']=1;
     // unset(self::$a['a']);
      echo count(self::$a);
    }
}
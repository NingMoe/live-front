<?php
/**
 * Created by PhpStorm.
 * User: yuangong
 * Date: 2017/10/4
 * Time: 17:01
 */
namespace app\push\controller;
use app\index\model\Chatcontents;
use think\Cache;
//require_once '../../../thinkphp/library/think/Cache.php';

// 加载框架引导文件
require "../../../public/router.php";
class Timer{

    public function index(){

    }
    public function __construct()
    {
      // Cache::set('aa',11,5);
       echo Cache::get('aa');
    }

}
$time = new Timer();


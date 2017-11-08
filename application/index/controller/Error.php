<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Error extends Controller
{
   public function index(){
       echo '您已在我们的黑名单内,暂时无法访问!!!';
   }
}

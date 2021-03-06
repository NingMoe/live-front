<?php
/**
 * Created by PhpStorm.
 * User: yuangong
 * Date: 2017/8/18
 * Time: 9:59
 */

namespace app\index\model;
use think\Model;

class Article extends Model
{
    public function getall($id){
        return Article::whereIn('typeid',$id)->select();
    }

    public function getone($id){
       return Article::get($id);
    }

    //点击数
    public function addclick($id){
        return Article::where('id',$id)->setInc('click_number',1);
    }

    //下载数
    public function adddownload($id){
        return Article::where('id',$id)->setInc('download_number',1);
    }
}
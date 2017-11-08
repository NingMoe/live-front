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
        return Article::where('article_id',$id)->setInc('click_number',rand(1,10));
    }

    //下载数
    public function adddownload($id){
        return Article::where('article_id',$id)->setInc('download_number',rand(1,10));
    }
}
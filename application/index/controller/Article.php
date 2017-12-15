<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Article extends Common
{
    public function index(){

        //查询文章类型
        $articletype = collection(model('Articletype')->getall())->toArray();
        $id = '';
        //根据文章类型 判断前端那个类型默认选中
        $typename = input('get.typename');
        if(!empty($typename)){
            foreach($articletype as $key=>$val){
                if($val['typename'] == $typename){
                    $articletype[$key]['this'] = 1;
                    $id = $articletype[$key]['id'];
                }
            }
        }else{
            $articletype[0]['this'] = 1;
            $id = $articletype[0]['id'];
        }

        $article = model('Article')->getall($id);

        return view('index',array(
            'articletype'=>$articletype,
            'article'=>$article
        ));

    }

    public function details(){

        //判断用户权限
        $typeid = input('get.typeid');
        $id = input('get.id');
        $group_id = session('user.group')['id'];
        $type = model('Articletype')->gettype($typeid)->toArray();
        if(!empty($type['group_id']) && in_array($group_id,json_decode($type['group_id'],true))){
            //查询指定文章
            $article = model('Article')->get($id);
            $name = model('Roominfo')->gettitle()->toArray();
            return view('details',array(
                'article'=>$article,
                'name'=>$name
            ));
        }else{
            echo '您没有权限访问';
        }
    }

    //点击数
    public function clickNumber(){
        $id = input('post.id');
        $article = model('Article')->addclick($id);
        if($article){
           echo '增加点击数成功';
        }else{
            echo '增加点击数失败';
        }
    }

    //下载数
    public function downloadNumber(){
        $id = input('post.id');
        $article = model('Article')->adddownload($id);
        if($article){
            echo '增加下载数成功';
        }else{
            echo '增加下载数失败';
        }
    }
}

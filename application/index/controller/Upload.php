<?php
namespace app\index\controller;
use think\Controller;

/**
*上传接口类
 */
class Upload extends Common
{
    //文件大小(字节) 默认5m
     const IMAGE_SIZE = 5000000;
     const RESTS_SIZE = 5000000;
     const IMAGE_URL  = ROOT_PATH . 'public/uploads/images';//绝对路径
     const IMAGES_URL_X = '/uploads/images/';//相对路径

     //上传图片
       public function image(){
           // 获取表单上传文件 例如上传了001.jpg
           $file = request()->file('file');
           // 移动到框架应用根目录/public/uploads/ 目录下
           if($file){
               //$info = $file->move(ROOT_PATH . 'public/uploads/images');
               $info = $file->validate(['size'=>self::IMAGE_SIZE,'ext'=>'jpg,png,gif'])->move(self::IMAGE_URL);
               if($info){
                    //返回文件目录(相对路径) 替换一下\斜杠
                   $src = 'http://'.$_SERVER['SERVER_NAME'].self::IMAGES_URL_X.$info->getSaveName();
                   $src = str_replace('\\','/',$src);
                    $img_info = array(
                        'code'=>200,
                        'msg'=>'上传成功',
                        'src'=>$src
                    );
                    return json_encode($img_info);
               }else{
                   // 上传失败获取错误信息
                   echo $file->getError();
               }
           }
       }

}

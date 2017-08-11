<?php
/**
 * Created by PhpStorm.
 * User: yuangong
 * Date: 2017/8/11
 * Time: 9:19
 */

namespace app\index\model;

use think\helper\Hash;
use think\Model;
use think\validate;
class User extends Model
{
    // 定义时间戳字段名
    protected $updateTime = 'login_time';
    protected $createTime = 'create_time';
    protected $autoWriteTimestamp = true;

    protected $rule = [
        'uname'=>'require|unique:user',
        'upwd'=>'require|min:6'
    ];

    protected $msg = [
        'uname.require'=>'账号必须',
        'upwd.require'=>'密码必须',
        'uname.unique'=>'账号已存在',
        'upwd.min'=>'密码最少六位数'
    ];

    // 对密码进行加密
    public function setPasswordAttr($value)
    {
        return Hash::make((string)$value);
    }

    //用户注册
    public function add($data){

        $validate = new Validate($this->rule,$this->msg);
        $result = $validate->check($data);
        if($result){

            $arr = [
                'uname'=>$data['uname'],
                'upwd'=>Hash::make((string)$data['upwd']),
                'head'=>'head.png',
                'nickname'=>$data['nickname'],
                'level'=>1
            ];
            $user = new User($arr);
            session('user',$arr);
            $user->save();
        }
        return $validate->getError();


    }

    public function login($data){
        $user = User::get(['uname'=>$data['uname']]);
        if($user!=NULL || !empty($user)){
            if(Hash::check($data['upwd'],$user->data['upwd'])){
                session('user',$user->data);
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}
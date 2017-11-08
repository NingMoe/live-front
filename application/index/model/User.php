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
    //protected $updateTime = 'login_time';
    //protected $createTime = 'create_time';
    //protected $autoWriteTimestamp = true;

//    protected $rule = [
//        'uname'=>'require|unique:user',
//        'upwd'=>'require|min:6'
//    ];
//
//    protected $msg = [
//        'uname.require'=>'账号必须',
//        'upwd.require'=>'密码必须',
//        'uname.unique'=>'账号已存在',
//        'upwd.min'=>'密码最少六位数'
//    ];

    // 对密码进行加密
    public function setPasswordAttr($value)
    {
        return Hash::make((string)$value);
    }

    //用户注册
    public function add($data){

        //$validate = new Validate($this->rule,$this->msg);
       // $result = $validate->check($data);
        $result = 1;
        if($result){

            $arr = [
                'uname'=>$data['uname'],
                'upwd'=>Hash::make((string)$data['upwd']),
                'head'=>'/static/images/youke'.rand(0,5).'.png',
                'nickname'=>$data['nickname'],
                'login_time'=>time(),
                'create_time'=>time(),
                'level'=>2
            ];
            $user = new User($arr);
            if(!empty($user->where('uname',$data['uname'])->find())){
                return '该账号已经注册';
            }
            if($user->save()){
                $level = model('level');
                $le = $level->getLevel($arr['level']);
                $arr['profile'] = $le;
                setSession($arr);
                return true;
            }else{
                return '账号注册失败';
            }
        }else{
           // return $validate->getError();
        }



    }

    public function login($data){
        $user = User::get(['uname'=>$data['uname']],'profile');
        if(!empty($user)){
            //查询成功更新登录时间
            $user->allowField('login_time')->save(array('login_time'=>time()),['uname'=>$data['uname']]);
            //如果查询成功 转化对象为数组
            $user = $user->toArray();
            if(Hash::check($data['upwd'],$user['upwd'])){
                setSession($user);
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //刷新用户状态
    public function saveUserStatus($data){
        $user = User::get(['uname'=>$data['uname']],'profile')->toArray();
        $group = model('Group')->getGroup($user['profile']['group_id']);
        $user['group'] = $group;
        if(!empty($user)){
            setSession($user);
            return 1;
        }
    }

    //查询老师数据
    public function teacherInfo(){
        $id = 5;//默认老师组id
        $level = model('Level')->getGroupId($id);//获取到等级的id
        $user  = User::all(['level'=>$level['id']]);
        return $user;
    }

    //关联查找
    public function profile()
    {
        return $this->hasOne('Level','id','level');
    }
}
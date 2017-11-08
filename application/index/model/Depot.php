<?php
/**
 * Created by PhpStorm.
 * User: yuangong
 * Date: 2017/8/18
 * Time: 9:59
 */

namespace app\index\model;
use think\Model;

class Depot extends Model
{
    public function add($data){
        $data['create_time'] = time();
        $data['depot_type'] = 1;//1表示建仓 2表示平仓
        $data['uid']  = session('user.uname');
        if(empty($data['uid'])){
            echo '用户ID不存在';
            return false;
        }
        return Depot::save($data);
    }

    public function saveJc($data){
        return Depot::update($data);
    }

    public function jiancang($where='',$limit=''){
        //判断是按照创建时间排序还是更新时间排序
        if($where['d.depot_type']==1){
            $ord = 'd.create_time desc';
        }else{
            $ord = 'd.end_time desc';
        }
        $depot = Depot::alias('d')
            ->Field('d.id as did,type,cangwei,kaicang,zhisun,pingcang,end_time,zhiying,maidan,uid,d.create_time,nickname,goods_name')
            ->where($where)
            ->join('yq_user u','d.uid=u.uname')
            ->join('yq_goods g','d.goods_id=g.goods_id')
            ->order($ord)
            ->limit($limit)
            ->select();
        return $depot;
    }

    //查询记录条数
    public function jcCount($where=''){
        return Depot::alias('d')->where($where)->count();
    }

    //删除
    public function del($id){
        return Depot::destroy($id);
    }

    //指定id查询
    public function getIdInfo($id){
        return Depot::get($id);
    }

    public function proUser(){
        return $this->hasOne('User','uname','uid');
    }

    public function proGoods(){
        return $this->hasOne('Goods','goods_id','goods_id');
    }
}
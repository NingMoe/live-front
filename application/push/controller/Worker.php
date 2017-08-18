<?php
/**
 * Created by PhpStorm.
 * User: yuangong
 * Date: 2017/8/11
 * Time: 15:52
 */

namespace app\push\controller;


use think\Cache;
use think\worker\Server;
use think\Controller;
class Worker extends Server
{
    protected $socket = 'websocket://127.0.0.1:2346';
    protected static $user   = array();
    /**
     * 收到信息
     * @param $connection
     * @param $data
     */
    public function onMessage($connection, $data)
    {
        $data = json_decode($data,true);
        switch($data['type']){

            case 0 :
                //连接建立成功存储用户信息
                self::$user[$connection->id]->userInfo = $data;
                break;

            case 1 :
                //消息推送
                $this->sendMsg($connection,$data);
                break;

        }
    }

    /**
     * 当连接建立时触发的回调函数
     * @param $connection
     */
    public function onConnect($connection)
    {
        self::$user[$connection->id] = $connection;
        //推送人数
        $this->pushPeople();
    }

    /**
     * 当连接断开时触发的回调函数
     * @param $connection
     */
    public function onClose($connection)
    {
        unset(self::$user[$connection->id]);
        //推送人数
        $this->pushPeople();
    }

    /**
     * 当客户端的连接上发生错误时触发
     * @param $connection
     * @param $code
     * @param $msg
     */
    public function onError($connection, $code, $msg)
    {
        echo "error $code $msg\n";
    }

    /**
     * 每个进程启动
     * @param $worker
     */
    public function onWorkerStart($worker)
    {

    }

    /**
     * 推送在线人数
     */
    public function pushPeople(){

    }


    /**
      * 开始推送消息
     */
    public function sendMsg($connection,$data){
       if($data['level']>=9){
           //如果等级大于等于9级直接推送给所有用户
           foreach(self::$user as $v){
               $this->save($data);
               $v->send(json_decode($data));
           }

       }
    }

    //保存消息
    public function save($data){
        $msg = model('chatcontents');
        $msg->add($data);
    }

}
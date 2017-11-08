<?php
/**
 * Created by PhpStorm.
 * User: yuangong
 * Date: 2017/8/11
 * Time: 15:52
 */

namespace app\push\controller;

use think\Controller;
use GatewayClient\Gateway;
use app\index\Model\Level;
use app\push\controller\Message;
use app\push\controller\Caches;
class Worker extends Controller
{

    /**
      *当前uid绑定clientId并分配用户组
     */
    public function bindUid(){
        if(request()->isPost()){
           $clientId = input('post.clientId');
           session('user.clientId',$clientId);

           //查询当前等级的用户组
           $level = new Level();
           $group = $level->getGroup(session('user.level'));
           if(!is_array($group)){
               echo $group;
           }
           //绑定用户组
           Gateway::joinGroup($clientId,$group['name']);
           //广播上线
            $data = session('user');
            $data['type'] = 'online';
           Gateway::sendToAll(json_encode($data),'',$clientId);
           //保存到在线用户列表
            $this->addUserFromList(session('user'));
           //将用户组保存到session
            session('user.group',$group);
            return $group;//返回group信息,让前端填充到localStorage
           //echo Gateway::getClientCountByGroup($group['name']);
        }
    }

    /**
      * 发言的推送
     */
    public function sendMsg(){
        if(request()->isPost()){
            $data['type'] = 'msg';
            $data['msg']  = input('post.msg');
            $data['mid']  = input('post.mid');
            $data['cid']  = input('post.cid');
            $data['is_check'] = session('user.group')['check_msg'];
            $data['time'] = time();
            //判断该条发言是否需要审核
            //如果需要审核,则拼装审核的按钮,否则拼装</div>结束
            if($data['is_check']){
                $data['msg'].='<i class="case1" onclick="checkMessage(this)">审核通过</i><i class="case2" onclick="deleteMessage(this)">删除</i></div>';
                Gateway::sendToGroup('管理',json_encode($data),session('user.clientId'));
            }else{
                $data['msg'].='</div>';
                Gateway::sendToAll(json_encode($data),'',session('user.clientId'));
            }

            //保存发言
            return Message::saveMsg($data);
        }
    }

    /**
      *管理员审核的推送
     */
    public function sendToAllMsg(){
        if(request()->isPost()){
            if(session('user.group')['check_msg']!=0){
                return '{"type":"error","msg":"对不起,您没有权限进行该项操作"}';
            }
            $data = input('post.');
            if($data['flag']=='pass'){
                $data['type'] = 'msg';
                Gateway::sendToAll(json_encode($data),'',session('user.clientId'));
                //更新发言的审核状态
                if(Message::saveMsgStatus($data['mid'])){
                    return '{"type":"success","msg":"审核通过.."}';
                }else{
                    return '{"type":"error","msg":"审核失败.."}';
                }
            }else if($data['flag']=='delete'){
                $data['type'] = 'delete';
                Gateway::sendToAll(json_encode($data),'',session('user.clientId'));
                //删除发言
                Message::deleteMsg($data['mid']);
                return '{"type":"success","msg":"删除成功.."}';
            }

        }
    }


    /**
    *弹幕飞屏推送
     */
    public function sendDanmu($data){
        $data['nickname'] = session('user.nickname');
        $data['head']  =  session('user.head');
        $data['type']  = 'feiping';
        Gateway::sendToAll(json_encode($data));
    }

    /**
     *黑名单跳转推送
     */
    public function bannedUser($clientId){
        $data['type']  = 'blackList';
        Gateway::sendToClient($clientId,json_encode($data));
    }

    /**
     * 建平仓提醒推送
     * @param $goods_type string 建仓还是平仓
     * @param $name string 建仓老师
     * @param $goods int 商品id
     * @param $url string 前端查看地址
    */
    public function sendDepot($goods_type,$name,$goods,$url){
        $data['goods_type'] = $goods_type;
        $data['name'] = $name;
        $data['goods'] = $goods;
        $data['url'] = $url;
        $data['type'] = 'jiancang';
        Gateway::sendToAll(json_encode($data));
    }

    //保存在线用户列表
    public function addUserFromList($user){
        Caches::setUserList($user);
        //dump(Caches::setUserList($user));
    }

    //用户从列表中剔除
    public function delUserFromList(){
        if(request()->isPost()){
            $key = input('post.clientId');
            Caches::delUserToList($key);
        }
    }


}
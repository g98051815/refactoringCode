<?php
namespace  AppInterFace\Model\Order;
use Admin\Model\Message\messageModel;
use Think\Model;

/**
 *线路商品基础模型（所有的模型继承到这一个模型里面去）
*/

class LineOrderBaseModel extends Model{

    protected $tableName = 'line_order';

    protected $generateOrderNo = true;

    private $orderNo; //用户的订单编号

    private $createTime; //订单的创建时间

    protected $orderPrefix; //订单前戳

    protected $userInfo; //订单前戳

    protected $goodsId; //商品id订单生成的元素

    public function _initialize(){
        //设置当前时区
        date_default_timezone_set('PRC');
        //获取当前的创建时间
        $this->setCreateTime();
        $this->userInfo =  get_user_info();
        if($this->generateOrderNo):
            if(empty($this->orderPrefix)):
                if(APP_DEBUG)
                    E('订单前戳不能为空！');
                else
                    messageModel::errorMsg('系统异常请稍后再试！');
            endif;
        endif;

        if(empty($this->userInfo)):
            if(APP_DEBUG)
                E('用户没有登陆！');
            else
                messageModel::errorMsg('请登陆后操作！');
        endif;
        if($this->generateOrderNo){
            $this->setOrderNo(); //生成订单编号
        }

    }

    /**
     * 创建生成时间
     */
    final function setCreateTime(){
        $this->createTime = time();
    }

    /**
     * 设置订单编号
     * 订单编号的生成规则[订单前戳+当前时间戳+当前用户的id号码]
     */
    final function setOrderNo(){

        $this->orderNo = $this->getOrderPrefix().$this->getCreateTime().$this->getUserInfo('uid');
        
    }


    protected function getOrderPrefix(){

        return $this->orderPrefix;

    }


    //获取创建的时间
    protected function getCreateTime(){
        return $this->createTime;
    }

    //获取订单编号
    protected function getOrderNo(){
        return $this->orderNo;
    }

    protected function getUserInfo($key=null){
        if(empty($key)){
            return $this->userInfo;
        }

        return $this->userInfo[$key];
    }
}
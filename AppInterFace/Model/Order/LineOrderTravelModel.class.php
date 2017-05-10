<?php
namespace  AppInterFace\Model\Order;
use AppInterFace\Model\Order\LineOrderBaseModel;

/**
 * 线路订单出游人列表模型
 * */

class LineOrderTravelModel extends LineOrderBaseModel{

    protected $generateOrderNo = false;

    protected $tableName = 'line_order_travel';

    protected $goodsInfo;
    //接收通知消息
    public function receive(){
        //添加出游人信息
        $travelPeople = $this->getGoodsInfo('travel_people');
        $data = array();
        foreach(explode(',',$travelPeople) as $val){
           $data['travel_id'] = (int) ($val);
           $data['order_no'] = $this->getGoodsInfo('order_no');
           $create = $this->create($data);
           $add = $this->add($create);
           if(!$add){
           		//回退并且跳出循环
           		$this->rollback();
           		return false;
           }
        }
        return true;

    }


    public function getGoodsInfo($key=null){
        if(is_null($key)){
           return $this->goodsInfo;
        }

        return $this->goodsInfo[$key];
    }

    public function setParams($params){
        $this->goodsInfo = $params;
    }
}
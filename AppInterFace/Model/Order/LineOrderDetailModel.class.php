<?php
namespace  AppInterFace\Model\Order;
use AppInterFace\Model\Order\LineOrderBaseModel;
/**
 * 商品详情生成模型
*/
class LineOrderDetailModel extends LineOrderBaseModel{

    protected $generateOrderNo = false;

    protected $goodsInfo;

    protected $tableName = 'line_order_detail';

    public function receive(){
        $create = $this->field($this->getDbFields())->create($this->getGoodsInfo());

        //发生错误后回滚整个菜单
        if(!$this->add($create)){
        	$this->rollback();
              return false;
        }
        return true;
    }


    public function getGoodsInfo(){

        return $this->goodsInfo;
    }


    public function setParams($params){

        $this->goodsInfo = $params;
    }
}
<?php
namespace AppInterFace\Controller;
use AppInterFace\Controller\BaseController;
use AppInterFace\Model\FactoryModel;
use Admin\Model\Message\messageModel;
class LineOrderController extends BaseController{

    public function indexAction(){
       $this->setObject(FactoryModel::lineOrder());
       $trlOrderData= $this->clearTrim(I('post.')); //是去除get或者post过来的值得左右空格的函数，最多支持二维数组
       if($trlOrderData['confirmation_condition'] != 1){
        	messageModel::errorMsg('请确认出游人信息！');
        }

         if($trlOrderData['reading_cause'] != 1){
        	messageModel::errorMsg('请阅读预定须知和其他条款！');
        }
       $this->trlData->setContacts($trlOrderData['contacts']); //联系人的姓名
       $this->trlData->setContactsPhone($trlOrderData['contacts_phone']);//联系人的电话号码
       $this->trlData->setContactsEmail($trlOrderData['contacts_email']); //联系人的电子邮件
       $this->trlData->setGoodsId($trlOrderData['line_goods_id']);//联系人购买的商品
       $this->trlData->setTypeId($trlOrderData['goods_id']);//联系人购买的商品id
       //$this->trlData->setCouponNo($trlOrderData['coupon_id']); //设置订单编号
       $this->trlData->setOutDateTime($trlOrderData['out_date_time']);//出行时间
       $this->trlData->setNumberAdults($trlOrderData['number']);//出行的成人数量
       $this->trlData->setTravelPeople($trlOrderData['travel_people']); //出行人
       $generateOrder = $this->trlData->generateOrder();
       if(false == $generateOrder){
       	 $errorMsg = $this->trlData->getError();
       	 messageModel::errorMsg($errorMsg);
       }
         messageModel::setMessageStock('order_no',$generateOrder);
      	 messageModel::successMsg('订单生成成功！');
    }


    /**
     * 获取订单详细信息
     * */
    public function getLineOrderInfoAction(){
    	$this->setObject(FactoryModel::lineOrderResult());
    	$this->trlData->setOrderNoFix('LO14936946093');
    	$response = $this->trlData->response();
    	dump($response);
    }


    public function responseLineOrderAction(){
       $this->setObject(FactoryModel::lineOrder());
       $trlOrderData= $this->clearTrim(I('post.')); //是去除get或者post过来的值得左右空格的函数，最多支持二维数组
       if($trlOrderData['confirmation_condition'] != 1){
          messageModel::errorMsg('请确认出游人信息！');
        }

         if($trlOrderData['reading_cause'] != 1){
          messageModel::errorMsg('请阅读预定须知和其他条款！');
        }
       $this->trlData->setContacts($trlOrderData['contacts']); //联系人的姓名
       $this->trlData->setContactsPhone($trlOrderData['contacts_phone']);//联系人的电话号码
       $this->trlData->setContactsEmail($trlOrderData['contacts_email']); //联系人的电子邮件
       $this->trlData->setGoodsId($trlOrderData['line_goods_id']);//联系人购买的商品
       $this->trlData->setTypeId($trlOrderData['goods_id']);//联系人购买的商品id
       //$this->trlData->setCouponNo($trlOrderData['coupon_id']); //设置订单编号
       $this->trlData->setOutDateTime($trlOrderData['out_date_time']);//出行时间
       $this->trlData->setNumberAdults($trlOrderData['adult_number']);//出行的成人数量
       $this->trlData->setNumberChild($trlOrderData['child_number']);//出行儿童的数量
       $this->trlData->setTravelPeople($trlOrderData['travel_people']);//出行人
       $generateOrder = $this->trlData->generateOrder();
       if(false == $generateOrder){
         $errorMsg = $this->trlData->getError();
         messageModel::errorMsg($errorMsg);
       }
         messageModel::setMessageStock('order_no',$generateOrder);
         messageModel::successMsg('订单生成成功！');
    }



}

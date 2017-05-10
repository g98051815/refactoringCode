<?php
namespace AppInterFace\Controller;
use Admin\Model\Message\messageModel;
use AppInterFace\Controller\BaseController;

class CouponController extends BaseController{
    /**
     * 获取优惠券
    */
    public function getCouponAction(){

        $coupon = new \Order\Controller\CouponController();
        if(IS_AJAX){
            messageModel::setMessageStock('list',$coupon->getCouponAction());
            messageModel::successMsg();
        }

        return $coupon->getCouponAction();

    }

    /**
     * 发送优惠券
    */
    public function pushCouponAction(){

        $coupon = new \Order\Controller\CouponController();
        $coupon->pushCouponAction();

    }

}

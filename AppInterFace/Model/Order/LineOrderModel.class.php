<?php
namespace  AppInterFace\Model\Order;
use AppInterFace\Model\FactoryModel;
use AppInterFace\Model\Order\LineOrderBaseModel;

/**
 * 线路订单模型
 * */

class LineOrderModel extends LineOrderBaseModel{

    protected $orderPrefix = 'LO';

    protected $orderInfo; //商品信息

    private $verify; //验证订单的合法性

    private $dbConfig; //数据库配置

    private $goodsStock; //商品库存

    private $trlObserver;//观察者

    function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->orderInfo['order_no'] = $this->getOrderNo();
        $this->orderInfo['uid'] = $this->getUserInfo('uid');
        $this->orderInfo['create_time'] = $this->getCreateTime();
        $this->orderInfo['note'] = 'NONE';
        $this->dbConfig['STOCK'] = 'line_stock';
        $this->dbConfig['GOODS'] = 'line';
        $this->dbConfig['COUPON_ACCESS'] = 'coupon_access';
        $this->dbConfig['COUPON'] = 'coupon';
        $this->setNumberChild(0);//设置默认值
        $this->setPreferentialAmount(0); //设置默认的优惠金额
        $this->setInvoiceHeader('NONE');//设置发票抬头的默认值
        $this->setCouponNo('NONE');//设置优惠券编号
        $this->setOrderStatus('2');//设置默认的订单状态
        $this->verify = FactoryModel::lineOrderVerify(); //验证订单的合法性
        $this->trlObserver = FactoryModel::obServer(__CLASS__);
    }

    //生成订单
    public function generateOrder(){
        $this->startTrans();
        $this->setGoodsStock(); //设置商品库存信息
        $this->setNumber();//计算订单的销售总数
        $this->setPrice($this->getGoodsStock('price'));//设置商品价格
        $this->setBackDateTime();//计算回团时间
        $this->setAmountPayable();//计算订单的应付金额
        $this->setActualPayment(); //设置实际支付金额
        $this->setTotalAmount();//设置订单总金额
        $this->verify->setValidate($this->getOrderInfo());
        if(!$this->verify->validateBegin()){
            $this->error = $this->verify->getError();
            return false;
        }
        //下降库存
        if(!$this->downStock()){
            $this->rollback();
            return false;
        }
        $create = $this->field($this->getDbFields())->create($this->getOrderInfo());
        if(!$create || !$this->add($create)){
            $this->error = '订单创建失败！';
            $this->rollback();
            return false;
        }
        $detail = FactoryModel::lineOrderDetail();
        $travel = FactoryModel::lineOrderTravel();
        $detail->setParams($this->getOrderInfo());
        $travel->setParams($this->getOrderInfo());
        if(!$detail->receive() || !$travel->receive()){
            $this->error = '订单生成失败请重试!';
            $this->rollback();
            return false;
        }
        //所有过程执行完毕提交操作
        $this->commit();
          //$sms = new \Admin\Model\Sms\SmsModel();
          //$sms->OrderFinshSms($this->getOrderInfo()); //订单完成验证码测试成功
          #$email = new \Admin\Model\Email\emailModel;
          #$email->orderFinsh($this->getOrderInfo());
        return $this->getOrderInfo('order_no');
    }

    //设置总金额
    private function setTotalAmount(){
        $this->orderInfo['total_amount'] = $this->getOrderInfo('actual_payment');
    }


    //设置订单的默认状态
    private function setOrderStatus($status){
        $this->orderInfo['status'] =$status;
    }


    public function setGoodsStock(){
        $db = $this->dbConfig;
        $where['type'] = array('eq',$this->getOrderInfo('type_id'));
        $where['date_time'] = array('eq',$this->getOrderInfo('out_date_time'));
        $this->goodsStock = M($db['STOCK'])->where($where)->field(false)->find();
    }

    //获取商品库存
    public function getGoodsStock($key=null){
        if(is_null($key)){
            return $this->goodsStock;
        }
        return $this->goodsStock[$key];
    }



    //减库存的操作
    private function downStock(){
        $config = $this->dbConfig;
        $where['type'] = array('eq',$this->getOrderInfo('type_id'));
        $where['date_time'] = array('eq',$this->getOrderInfo('out_date_time'));
        $stock = M($config['STOCK']);
        $number = $stock->where($where)->field(['number'])->lock(true)->find()['number'];
        $data['number'] = $number-$this->getOrderInfo('number');
        if(!$stock->where($where)->lock(true)->save($stock->create($data))){
            $this->error = '购买失败！';
            return false;
        }
        return true;
    }



    //设置商品id
    public function setGoodsId($goodsId){
        $this->orderInfo['goods_id'] = $goodsId;
        return $this;
    }

    //设置联系人
    public function setContacts($contacts){
        $this->orderInfo['contacts'] = $contacts;
        return $this;
    }

    //设置联系人电话
    public function setContactsPhone($contactsPhone){
        $this->orderInfo['contacts_phone'] = $contactsPhone;
    }

    //设置成人的出行数量
    public function setNumberAdults($adults){
        $this->orderInfo['number_adults'] = $adults;
    }

    //设置儿童的出行数量
    public function setNumberChild($child){
        $this->orderInfo['number_child'] = $child;
    }

    //设置出行的总人数，出行的总人数是成人数量加上儿童的数量
    private function setNumber(){

        $this->orderInfo['number'] = $this->getOrderInfo('number_adults')+$this->getOrderInfo('number_child');

    }


    //设置联系人电子邮件
    public function setContactsEmail($contactsEmail){

        $this->orderInfo['contacts_email'] = $contactsEmail;
        return $this;
    }

    //设置发票抬头
    public function setInvoiceHeader($invoiceHeader){

        $this->orderInfo['invoice_header'] = $invoiceHeader;
        return $this;
    }
    


    //设置折扣金额
    public function setPreferentialAmount($preferentialAmount){
        $this->orderInfo['preferential_amount'] = $preferentialAmount;
        return $this;
    }
    //设置出游时间
    public function setTypeId($typeId){

        $this->orderInfo['type_id'] = $typeId;
        return $this;
    }

    //设置出游时间
    public function setOutDateTime($outDateTime){
        if(strstr($outDateTime,'年')){
            $outDateTime = str_replace('年','/',$outDateTime);
            $outDateTime = str_replace('月','/',$outDateTime);
            $outDateTime = str_replace('日','',$outDateTime);
        }
        $this->orderInfo['out_date_time'] = strtotime($outDateTime);
        return $this;
    }

    //计算回团时间
    private function setBackDateTime(){
        $db = $this->dbConfig;
        $where['id'] = array('eq',$this->getOrderInfo('goods_id'));
        $backDateTime = M($db['GOODS'])->where($where)->field(['back_group_date'])->find()['back_group_date'];
        $this->orderInfo['back_date_time'] = strtotime('+ '.$backDateTime.' Day',$this->getOrderInfo('out_date_time'));
    }

    //设置商品价格
    private function setPrice($price){
        $this->orderInfo['price'] = $price;
        return $this;
    }

    //设置实际支付金额
    private function setActualPayment(){
        $amountPayable = $this->getOrderInfo('amount_payable'); //应付金额
        $preferentialAmount = $this->getOrderInfo('preferential_amount'); //实际付款金额
        $this->orderInfo['actual_payment'] = $amountPayable-$preferentialAmount; //应付金额
    }

    //设置优惠券编号,并且设置优惠金额
    public function setCouponNo($couponNo){
        $db = $this->dbConfig;
        $this->orderInfo['coupon_no'] = $couponNo;
        if($couponNo == 'NONE'){return;}
        $where['trl_'.$db['COUPON_ACCESS'].'.coupon_no'] = array('eq',$this->getOrderInfo('coupon_no'));
        $where['trl_'.$db['COUPON_ACCESS'].'.uid'] = array('eq',get_user_info('uid'));
        $join = 'inner join __COUPON__ ON __COUPON_ACCESS__.coupon_id = __COUPON__.id';
        $field []= 'trl_'.$db['COUPON'].'.price';
        $field []= 'trl_'.$db['COUPON_ACCESS'].'.status as access_status';
        $field []= 'trl_'.$db['COUPON'].'.status';
        $field []= 'trl_'.$db['COUPON'].'.begin_time';
        $field []= 'trl_'.$db['COUPON'].'.expiration_time';
        $couponInfo = M($db['COUPON_ACCESS'])->where($where)->field($field)->join($join)->find();
        $this->setPreferentialAmount(is_null($couponInfo['price'])? 0 : $couponInfo['price']); //设置优惠金额
        return $this;
    }

    //设置出游人
    public function setTravelPeople($travelPeople){
        $this->orderInfo['travel_people'] = $travelPeople;
        return $this;
    }

    //设置应付款金额，此方法传入商品购买总数
    private function setAmountPayable(){
        $this->orderInfo['amount_payable'] = ($this->getOrderInfo('price')*$this->getOrderInfo('number'));
    }

    //获取当前的订单信息
    public function getOrderInfo($key=null){
        if(is_null($key)){
            return $this->orderInfo;
        }else{
            return $this->orderInfo[$key];
        }
    }

}
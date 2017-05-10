<?php
namespace AppInterFace\Controller;
use AppInterFace\Controller\BaseController;
use AppInterFace\Model\FactoryModel;
use Admin\Model\Message\messageModel;
class GoodsController extends BaseController{

    /**
     * 获取商品的详细信息
    */
    public function indexAction(){
        $goodsId = I('get.gid');
        $this->setObject(FactoryModel::goodsInfo());
        $this->trlData->setGoodsId($goodsId);
        $result = $this->trlData->response();
        //dump($result);
        messageModel::setMessageStock('info',$result);
        messageModel::successMsg();
    }

    /**
     * 获取商品的介绍页面
    */
    public function resultGoodsDocAction(){
        $column = I('get.col');
        $goodsId= I('get.gid');
        $this->setObject(FactoryModel::resultGoodsDocument());
        $this->trlData->setGoodsId($goodsId);
        $this->trlData->setResponseColumn($column);
        $result = $this->trlData->response();
        messageModel::setMessageStock('info',$result);
        messageModel::successMsg();

    }


    /**
     * 获取商品的幻灯片
    */
    public function resultGoodsSlidePicAction(){
        $goodsId = I('get.gid');
        $this->setObject(FactoryModel::resultGoodsSlidePic());
        $this->trlData->setGoodsId($goodsId);
        $result = $this->trlData->response();
        return $result;
       // dump($result);
    }

    public function resultGoodsChildTypeAction(){
      $goodsId = I('get.gid');
      $type = M('goods_type');
      $response = $type->where('gid='.$goodsId)->select()[0];
      dump($response);
    }

    /**
     *获取最近三个月的库存
    */
    public function resultStockAction(){
        $goodsId = I('get.gid');
        $this->setObject(FactoryModel::resultGoodsStock());
        $this->trlData->setGoodsId($goodsId);
        $result = $this->trlData->response();
        dump($result);
    }

    /**
     * 商品收藏
    */
    public function goodsCollection(){
        $goodsId = I('get.gid');
    }




}

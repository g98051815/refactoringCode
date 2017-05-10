<?php
namespace AppInterFace\Controller;
use Admin\Model\Message\messageModel;
use AppInterFace\Controller\BaseController;
use AppInterFace\Model\FactoryModel;

class ShowcaseController extends BaseController{

    public function _initialize(){

        $this->trlData = FactoryModel::showCase();

    }



    public function indexAction($showCaseName){
        $this->trlData->setShowCaseName($showCaseName);
        $list =$this->trlData->response();

        return $list;
    }

    public function indexsAction(){
        $showCaseName = I('get.name');
        $this->trlData->setShowCaseName($showCaseName);
        $result = $this->trlData->response();
       
        if(empty($result)){
            messageModel::errorMsg($this->trlData->getError());
        }
        messageModel::setMessageStock('list',$result);
        messageModel::successMsg('调用成功!');

    }

    /**
     * 显示橱窗的列表
    */
    public function showCaseListAction(){
        $result = $this->trlData->resultList();
        //dump($result);
        messageModel::setMessageStock('list',$result);
        messageModel::successMsg('获取成功！');
    }

}

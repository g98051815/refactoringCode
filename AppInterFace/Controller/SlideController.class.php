<?php
namespace AppInterFace\Controller;
use AppInterFace\Controller\BaseController;
use AppInterFace\Model\FactoryModel;

class SlideController extends BaseController{

    private $trlData = '';

    public function responsePcAction(){
        $formData= I('get.');
        $this->setObject(FactoryModel::slideGroupAccess());
        $this->trlData->setGroupName('pc');
        $this->trlData->setGroupTitle($formData['group_name']);
        $ret = $this->trlData->response();
        $this->ajaxReturn($ret);
    }


    public function responseApp(){
        $formData= I('get.');
        $this->setObject(FactoryModel::slideGroupAccess());
        $this->trlData->setGroupName('app');
        $this->trlData->setGroupTitle($formData['group_name']);
        $ret = $this->trlData->response();
        $this->ajaxReturn($ret);
    }


    public function responseMobile(){
        $formData= I('get.');
        $this->setObject(FactoryModel::slideGroupAccess());
        $this->trlData->setGroupName('mobile');
        $this->trlData->setGroupTitle($formData['group_name']);
        $ret = $this->trlData->response();
        $this->ajaxReturn($ret);
    }


    public function setObject($object){
        $this->trlData = $object;
    }
}

?>
<?php
namespace AppInterFace\Controller;
use AppInterFace\Controller\BaseController;
use AppInterFace\Model\FactoryModel;
class CateController extends BaseController{

    public function indexAction(){

        $this->setObject(FactoryModel::Cate());
        $response = $this->trlData->getCate('all','all');
        dump($response);

    }


}

?>
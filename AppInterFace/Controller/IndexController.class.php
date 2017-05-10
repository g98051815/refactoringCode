<?php
namespace AppInterFace\Controller;
use AppInterFace\Controller\BaseController;
use AppInterFace\Model\FactoryModel;
class IndexController extends BaseController{

        private  $data = array();

        /**
         * 首页的数据接口
        */
        public function IndexAction(){

            $cate = I('get.cate');
            $type = I('get.type');
            
            //新建分类模型
            $this->setResponse(FactoryModel::Cate());
            $ret = $this->data->getCate($cate,$type);
            dump($ret);
            return $ret;
            /*dump($ret);
            exit;
*/           // $this->ajaxReturn($ret);
        }

        /**
         * 默认是新建列表
        */
        public function setResponse($responseType){

            $this->data = $responseType;
        }


}
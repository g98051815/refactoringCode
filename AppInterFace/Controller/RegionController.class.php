<?php
namespace AppInterFace\Controller;
use AppInterFace\Controller\BaseController;
use AppInterFace\Model\FactoryModel;

/**
 * 行政区
*/
class RegionController extends  BaseController{


    /**
     * 获取行政区列表
    */
    public function responseAction(){
        $region = I('get.region');
        $regionCode =I('recode');
        if($region == 'province' || $region == '省'){
            $this->setObject(FactoryModel::regionResponseProvince());
        }

        if($region == 'city' || $region == '市'){
            $this->setObject(FactoryModel::regionResponseCity());
        }


        if($region == 'area' || $region == '区'){
            $this->setObject(FactoryModel::regionResponseArea());
        }

        if(empty($region) || $region == '全部'){
            $this->setObject(FactoryModel::regionResponse());
        }
        $this->trlData->setRegion($regionCode);
        $response = $this->trlData->response();
        dump($response);
    }


    /**
     * 获取行政区下面的所有行政区
    */


    /**
     * 获取行政区上面的所有行政区
    */


    /**
     *
    */

}
?>
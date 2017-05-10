<?php
namespace AppInterFace\Model\Region;
use AppInterFace\Model\FactoryModel;
use AppInterFace\Model\Region\RegionBaseModel;
use AppInterFace\Model\Region\RegionInterFaceModel;
class RegionResponseModel extends RegionBaseModel implements RegionInterFaceModel{

     protected $autoCheckFields = false;

     protected $trlProvince;

     protected $trlCity;

     protected $trlArea;

     protected $trlMmd = array('北京市','天津市','上海市','重庆市'); //直辖市
     public function _initialize()
     {
         parent::_initialize();
         $this->trlProvince = FactoryModel::regionResponseProvince();
         $this->trlArea = FactoryModel::regionResponseArea();
         $this->trlCity = FactoryModel::regionResponseCity();
     }

    /**
     * 统一返回接口
    */
    public function response()
     {
         $this->trlProvince->setRegion($this->region);
         $this->trlArea->setRegion($this->region);
         $this->trlCity->setRegion($this->region);
         $province = $this->trlProvince->responseCount();
         $city = $this->trlCity->responseCount();
         $area = $this->trlArea->responseCount();
         //省份存在，向下探索
         if($province > 0){
             //正向查找
           return  $this->searchCityOfFather($this->trlProvince->response());
         }

         if($city > 0){
             //正向查找
           return $this->searchAreaOfFather($this->trlCity->response());
         }

         if($area > 0){
             //正向查找
             return $this->searchAreaOfFather($this->trlArea->response());
         }
     }

    /**
     * 查找市
    */
     protected function searchCityOfFather($param){
         $code = array_column($param,'provinceid');
         $this->trlCity->searchParent(true);
         $this->trlCity->setRegion(implode(',',$code));
         $response = $this->trlCity->response();
         $cityResponse = $this->searchAreaOfFather($response);
         foreach($cityResponse as $val){
            $response[] = $val;
         }
         $response[]=$param[0];
         return $response;
     }



    /**
     *查找区
    */
    protected function searchAreaOfFather($param){

        $code = array_column($param,'cityid');
        $this->trlArea->searchParent(true);
        $this->trlArea->setRegion(implode(',',$code));
        $response =  $this->trlArea->response();
        $response[] = $param[0];
        return $response;
    }


}
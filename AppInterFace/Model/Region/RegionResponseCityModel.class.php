<?php
namespace AppInterFace\Model\Region;
use AppInterFace\Model\Region\RegionBaseModel;
use AppInterFace\Model\Region\RegionInterFaceModel;

class RegionResponseCityModel extends RegionBaseModel implements RegionInterFaceModel{

    protected $tableName = 'city';
    protected $searchParent = false;
    public function _initialize(){
        parent::_initialize();
        $this->trlData->_afterOperation($this);
    }

    public function _afterString($condition){

        return array('city'=>array('like',''.$condition.'%'));
    }

    public function _afterNumeric($condition){

        if(!$this->searchParent){

            return array('cityID'=>array('eq',$condition));
        }

        return array('father'=>array('eq',$condition));

    }


    public function searchParent($boolean){

        $this->searchParent = $boolean;

    }
}
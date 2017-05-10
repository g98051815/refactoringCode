<?php
namespace AppInterFace\Model\Region;
use AppInterFace\Model\Region\RegionBaseModel;
use AppInterFace\Model\Region\RegionInterFaceModel;
use AppInterFace\Model\FactoryModel;
class RegionResponseProvinceModel extends RegionBaseModel implements RegionInterFaceModel{
    protected $tableName = 'province';

    public function _initialize(){
        parent::_initialize();
        $this->trlData->_afterOperation($this);
    }


    public function _afterString($condition){
        return array('province'=>array('like',''.$condition.'%'));
    }

    public function _afterNumeric($condition){
        return array('provinceID'=>array('eq',$condition));

    }

}

?>
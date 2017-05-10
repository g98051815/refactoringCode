<?php
namespace AppInterFace\Model\Region;
use AppInterFace\Model\Region\RegionBaseModel;
use AppInterFace\Model\Region\RegionInterFaceModel;
use AppInterFace\Model\FactoryModel;
/**省份*/
class RegionResponseAreaModel extends RegionBaseModel implements RegionInterFaceModel{

    protected $tableName = 'area';
    protected $searchParent = false;

    public function _initialize(){
        parent::_initialize();
        $this->trlData->_afterOperation($this);
    }


    public function _afterString($condition){
           return array('area'=>array('like',''.$condition.'%'));
    }

    public function _afterNumeric($condition){
        if(!$this->searchParent){
            return array('areaID'=>array('eq',$condition));
        }
        return array('father'=>array('eq',$condition));
    }


    public function _afterStringMore($condition){

    }


    public function _afterNumericMore($condition){
        if(!$this->searchParent){
            return array('areaID'=>array('in',$condition));
        }
        return array('father'=>array('in',$condition));
    }

    public function searchParent($boolean){

        $this->searchParent = $boolean;

    }

}
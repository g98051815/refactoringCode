<?php
namespace AppInterFace\Model\Cate;
use AppInterFace\Model\factoryModel;
use AppInterFace\Model\Cate\CateInterFaceModel;
use Think\Model;
class CateSelfModel extends Model implements CateInterFaceModel{

    protected $tableName = 'cate';

    protected $trlData;

    private $trlCate;

    private $numeric='cid';

    public function response()
    {
        $this->setNumeric('cid');
        $fn = FactoryModel::instantiation('StringToolsModel');
        $fn->_afterOperation($this);
        return  $this->where( $fn->is($this->trlCate) )->fetchSql(false)->select();

    }


    public function setCate($trlCate)
    {
        $this->trlCate = $trlCate;
    }




    protected function setNumeric($numeric){


        $this->numeric = $numeric;

    }


    protected function getNumeric(){

        return $this->numeric;

    }



    public function _afterString($condition){
        $where['cate_name'] = array('eq',$condition);
        return $where;
    }


    public function _afterStringMore($condition){

        $where['cate_name'] = array('in',$condition);
        return $where;

    }


    public function _afterNumeric($condition){

        $where[$this->getNumeric()] = array('eq',$condition);
        return $where;
    }


    public function _afterNumericMore($condition){

        $where[$this->getNumeric()] = array('in',$condition);
        return $where;
    }



}
<?php
namespace AppInterFace\Model\Cate;
use AppInterFace\Model\Cate\CateInterFaceModel;
use AppInterFace\Model\FactoryModel;
use Think\Model;
class CateChildModel extends Model implements CateInterFaceModel{

    protected $tableName = 'cate';

    private $numeric='cid';

    private $trlCate;



    public function response()
    {
        return $this->getCateChildList();
    }

    public function setCate($cate){

        $this->trlCate = $cate;

    }


    protected function getCateChildList(){
        $condition = $this->trlCate;
        $this->setNumeric('cid');
        $fn = FactoryModel::instantiation('StringToolsModel');
        $fn->_afterOperation($this);
        $ret = $this->where( $fn->is($this->trlCate) )->select();
        $catePid = array_column($ret,'cid');
        if(count($catePid) > 1){
            $catePid = implode(',',$catePid);
        }else{
            $catePid = $catePid[0];
        }
        $this->setNumeric('cate_pid');
        $ret = $this->where( $fn->is($catePid) )->select();
        return $ret;
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
<?php
namespace AppInterFace\Model\Cate;
use AppInterFace\Model\FactoryModel;
use Think\Model;

class CateBaseModel extends Model{

    protected $tableName = 'cate';

    protected $trlData;


    /**
     * 获取分类
    */
    public function getCate($condition,$type='self'){
        if(empty($condition)){
            $this->error = '空的！';
            return false;
        }
        if($type=='self' || $type=='自身'){

            $this->setObject(FactoryModel::cateSelf());
        }

        if($type=='child' || $type=='子类'){

            $this->setObject(FactoryModel::cateChild());
        }


        if($type=='all' || $type=='全部'){
           
             $this->setObject(FactoryModel::allCate());
        }


        $this->trlData->setCate($condition);
       return  $this->trlData->response();

    }



    public function setObject($object){
    
        $this->trlData = $object;

    }








}
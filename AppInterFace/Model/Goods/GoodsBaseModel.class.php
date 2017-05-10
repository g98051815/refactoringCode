<?php
namespace AppInterFace\Model\Goods;
use Think\Model;
class GoodsBaseModel extends Model{

    protected $trlData;


    protected function setObject($object){

        $this->trlData = $object;
    }

}
<?php
namespace AppInterFace\Model\GoodsStock;
use Think\Model;

class GoodsStockBaseModel extends Model{

    protected $trlData;


    public function setObject($object){

        $this->trlData = $object;

    }

}
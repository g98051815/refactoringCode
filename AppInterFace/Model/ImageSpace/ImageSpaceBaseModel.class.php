<?php
namespace AppInterFace\Model\ImageSpace;
use Think\Model;

class ImageSpaceBaseModel extends Model{

    protected $autoCheckFields=false;

    protected $trlData;


    public function setObject($object){

        $this->trlData = $object;

    }

}
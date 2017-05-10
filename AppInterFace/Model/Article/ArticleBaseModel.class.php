<?php
namespace AppInterFace\Model\Article;
use Think\Model;

class ArticleBaseModel extends Model{

    protected $trlData;


    public function setObject($object){

        $this->trlData = $object;

    }


      protected function htmlEntityDecode(&$result){
        $result = html_entity_decode($result);
   	 }

}
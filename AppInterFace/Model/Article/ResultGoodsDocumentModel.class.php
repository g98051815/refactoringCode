<?php
namespace AppInterFace\Model\Article;
use AppInterFace\Model\Article\ArticleBaseModel;
use AppInterFace\Model\Article\ArticleInterFaceModel;
use AppInterFace\Model\FactoryModel;

class ResultGoodsDocumentModel extends ArticleBaseModel implements ArticleInterFaceModel{
    private $goodsId;
    private $responseColumn = 'introduce';
    protected $tableName = 'line_documents';
    /**
     *获取商品的库存
    */
    public function response()
    {
        $goodsId = $this->getGoodsId();
        $column = $this->getResponseColumn();
        $where['gid'] = array('eq',$goodsId);
        $field = array();
        if($column == 'all'):
            $field = false;
        else:
            $field[] = $column;
        endif;
       $result = $this->where($where)->field($field)->find();
       $this->htmlEntityDecode($result[$column]);
       return $result;
    }



    public function setGoodsId($goodsId){
        $this->goodsId = $goodsId;
    }

    private function getGoodsId(){
        $goodsId = $this->goodsId;
        if(empty($goodsId)){
            echo '商品id不能为空！';
            exit;
        }
        return $goodsId;
    }

    /**
     * 设置获取的字段
    */
    public function setResponseColumn($column){
       if(empty($column)){
            return;
       }
        $this->responseColumn = $column;
    }

    /**
     * 获取内容
    */
    private function getResponseColumn(){
        return  $this->responseColumn;
    }

}
<?php
namespace AppInterFace\Model\Goods;
use AppInterFace\Model\Goods\GoodsBaseModel;

class GoodsInfoModel extends GoodsBaseModel implements GoodsInterFaceModel{
    protected $tableName = 'line';
    private $goodsId;

    /**
     * 调用商品数据信息
     * 调用商品数据
    */
    public function response(){
        $goodsId = $this->goodsId;
        $this->verifyGoodsId($goodsId);
        $where[$this->getTableName().'.id'] = array('eq',$goodsId);
        $field[] = $this->getTableName().'.introduce';
        $response = $this->where($where)->field($field,true)->find();
        $type = M('line_type');
        $response['goods_type'] =   $type->where('gid = '.$response['id'])->select();
        return $response;
    }



    private function verifyGoodsId($goodsId){

        if(empty($goodsId)){
           echo '商品id不能为空';
           exit;
        }

    }



    public function setGoodsId($goodsId){
        $this->goodsId = $goodsId;
    }

}

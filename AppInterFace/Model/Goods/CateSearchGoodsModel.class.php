<?php
/**
 * 通过地区筛选商品
 * 通过地区和目的地进行筛选
 */
namespace AppInterFace\Model\Goods;
use AppInterFace\Model\FactoryModel;
use AppInterFace\Model\Goods\GoodsBaseModel;
use AppInterFace\Model\Goods\GoodsInterFaceModel;
use AppInterFace\Model\Region\RegionResponseModel;
class CateSearchGoodsModel extends GoodsBaseModel implements GoodsInterFaceModel{

    protected $tableName = 'line';

    protected $keywords = '';

    protected $trlLimit = 0;

    public function response()
    {
        $this->setObject(FactoryModel::Cate());
        $cate=$this->trlData->getCate($this->keywords);
        dump($cate);
        $where['cid'] = array('eq',array_column($cate,'cid')[0]);
        return $this->where($where)->fetchSql(false)->limit(0)->select();
    }


    public function setKeyWords($keywords){

        $this->keywords = $keywords;
    }


    public function setLimit($limit){

        $this->trlLimit = $limit;

    }



}
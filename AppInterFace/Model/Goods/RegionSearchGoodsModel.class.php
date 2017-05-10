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
class RegionSearchGoodsModel extends GoodsBaseModel implements GoodsInterFaceModel{

    protected $tableName = 'line';

    protected $keywords = '';

    protected $trlLimit = 0;

    public function response()
    {
        $this->setObject(FactoryModel::regionResponse());
        $this->trlData->setRegion($this->keywords);
        $region = $this->trlData->response();
        $cityId = array_column($region,'cityid');
        $areaid = array_column($region,'areaid');
        $province = array_column($region,'provinceid');
        $regionCode= array_merge_recursive($cityId,$areaid,$province);
        $where['areaid'] = array('in',$regionCode);
        return $this->where($where)->fetchSql(false)->limit(0)->select();
    }


    public function setKeyWords($keywords){

        $this->keywords = $keywords;
    }


    public function setLimit($limit){

        $this->trlLimit = $limit;

    }



}
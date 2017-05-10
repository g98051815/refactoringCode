<?php
namespace AppInterFace\Model\Region;
use Think\Model;
use AppInterFace\Model\FactoryModel;
class RegionBaseModel extends Model{

    protected $region='all'; //目的地列表

    protected $trlData;

    protected $trlColumn = array();

    public function _initialize(){

        $this->setObject(FactoryModel::stringToolsModel());
    }
    /**
     * 获取行政区列表形式
    */
    public function response(){
        if($this->region == 'all'){
            return $this->select();
        }else{
            $where = $this->trlData->is($this->region);
            return $this->where($where)->field(false)->fetchSql(false)->select();
        }

    }


    /**
     * 行政区的统计数目
    */
    public function responseCount(){
        if(empty($this->region)){
            E('行政区不能为空！');
        }
        $where = $this->trlData->is($this->region);
        return $this->where($where)->count();
    }




    /**
     * 获取所有商品的地区标志
     */
    public function getGoodsAreaCode(){
        $ret = $this->where('areaid !="" ')->table('trl_line')->field(['areaid'])->select();
        return $ret;
    }



    public function setRegion($region){
        if(empty($region)){
            return;
        }
        $this->region = $region;
    }


    protected function setObject($object){

        $this->trlData = $object;

    }

}
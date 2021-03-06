<?php
namespace AppInterFace\Model\GoodsStock;
use AppInterFace\Model\GoodsStock\GoodsStockBaseModel;

class GoodsStockModel extends GoodsStockBaseModel{
    private $goodsId;
    private $intervalTime;
    protected $autoCheckFields = false;
    private $dbConfig ;

    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->intervalTime='+3 Month';
        $this->dbConfig ['LINE_TYPE']= 'trl_line_type';
        $this->dbConfig['LINE_STOCK'] = 'trl_line_stock';
        //查看从今天开始加3个月后的库存数量
    }

    public function response(){
        $intervalTime = $this->intervalTime;
        $config = $this->dbConfig;
        $goodsId = $this->getGoodsId();
        $where[$config['LINE_TYPE'].'.gid'] = array('eq',$goodsId);
        $where[$config['LINE_STOCK'].'.date_time'] = array(array('gt',time()),array('lt',strtotime($intervalTime)),'and');
        $where[$config['LINE_TYPE'].'.status'] = array('eq','1');
        $where[$config['LINE_STOCK'].'.status'] = array('eq','1');
        $field[] = $config['LINE_STOCK'].'.type';
        $field[] = $config['LINE_STOCK'].'.number';
        $field[] = $config['LINE_STOCK'].'.price';
        $field[] = $config['LINE_TYPE'].'.gid';
        $result = $this->table($config['LINE_TYPE'])->where($where)->join('__LINE_STOCK__ ON __LINE_TYPE__.id = __LINE_STOCK__.type')->fetchSql(false)->field($field)->select();
        return $result;
    }


    //获取最近三个月的库存信息
    public function setResponseTime(){

    }


    //设置商品的id
    public function setGoodsId($goodsId){

        $this->goodsId = $goodsId;

    }


    //获取商品的id
    private function getGoodsId(){
        $goodsId = $this->goodsId;
        if(empty($goodsId)){
            echo '商品id不能为空！';
            exit;
        }
        return $goodsId;
    }
}
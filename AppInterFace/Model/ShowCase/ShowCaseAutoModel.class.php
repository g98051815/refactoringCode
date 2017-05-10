<?php
namespace AppInterFace\Model\ShowCase;
use AppInterFace\Model\ShowCase\ShowCaseBaseModel;
/**
 * 直接进行搜索
 */
class ShowCaseAutoModel extends ShowCaseBaseModel{
    protected $tableName = 'showcase_menus';
    private $showCaseId;
    private $rule;

    /**
     * 获取自动获取商品的内容
     */
    public function response(){

        //通过确定的橱窗检索商品内容
        $where['showcase_id'] = array('eq',$this->getShowCaseId());
        $response = $this->where($where)->field(false)->select();
        $this->rule = M('showcase_rule')->where($where)->find();
        if(empty(I('get.relation'))){
            $this->resultGoodsList($response);
        }
        return $response;
    }

    /**
     * 获取商品的数据然后进行拼接
    */
    public function resultGoodsList(&$result){
        $where['cid'] = array('in',array_column($result,'cid'));
        $ret = $this->table($this->tablePrefix.'line')->where($where)->limit($this->rule['number'])->select();
        foreach($result as &$items){
            foreach($ret as $val){
                if($items['cid'] == $val['cid']){
                    $items['list'][] = $val;
                }
            }
        }
    }


    public function getShowCaseId(){

        return $this->showCaseId;

    }


    public function setShowCaseId($showCaseId){

        $this->showCaseId = $showCaseId;

    }


}
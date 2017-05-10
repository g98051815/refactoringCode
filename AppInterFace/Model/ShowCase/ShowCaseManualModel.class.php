<?php
namespace AppInterFace\Model\ShowCase;
use AppInterFace\Model\ShowCase\ShowCaseBaseModel;
/**
 * 直接进行搜索
*/
class ShowCaseManualModel extends ShowCaseBaseModel{
    protected $tableName = 'showcase_contents';
    private $showCaseId;

    /**
     * 获取自动获取商品的内容
     */
    public function response(){
        //通过确定的橱窗检索商品内容
        $where['showcase_id'] = array('eq',$this->getShowCaseId());
        return $this->where($where)
            ->join('inner join __LINE__ ON __SHOWCASE_CONTENTS__.gid = __LINE__.id')->field(false)->limit(8)->select();
    }


    public function getShowCaseId(){

        return $this->showCaseId;

    }


    public function setShowCaseId($showCaseId){

        $this->showCaseId = $showCaseId;

    }


}
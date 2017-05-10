<?php
namespace AppInterFace\Model\Slide;
use Think\Model;
class SlideBaseModel extends Model{

    protected $tableName = 'slide_group';

    protected $groupName = '';  //组名称

    protected $groupTitle = '';  //栏目名称

    protected $trlLimit = 0; //限制条数

    protected $trlOrder = 'id'; //排序栏目



    public function SetGroupName($groupName)
    {
        $this->groupName = $groupName;
    }

    public function setGroupTitle($groupTitle)
    {
        $this->groupTitle = $groupTitle;
    }

    public function setLimit($limit){

        $this->trlLimit = $limit;

    }

    public function setOrder($order){

        $this->trlOrder = $order;

    }

    public function getGroupName(){
        return $this->groupName;
    }

    public function getGroupTitle(){
        return $this->groupTitle;
    }


}
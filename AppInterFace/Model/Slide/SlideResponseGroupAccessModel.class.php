<?php
namespace AppInterFace\Model\Slide;
use AppInterFace\Model\Slide\SlideBaseModel;
use AppInterFace\Model\Slide\SlideInterFaceModel;

class SlideResponseGroupAccessModel extends SlideBaseModel implements SlideInterFaceModel{



    public function response(){
        $this->setOrder('trl_slide_group_access.slide_order desc');
        $where['trl_slide_group.slide_group_name']= $this->getGroupName();
        $where['trl_slide_group.slide_group_title'] = $this->getGroupTitle();
        $field = false;
        return $this->where($where)
            ->join('INNER JOIN __SLIDE_GROUP_ACCESS__ ON __SLIDE_GROUP__.id= __SLIDE_GROUP_ACCESS__.slide_group_id ')
            ->field($field)->limit($this->trlLimit)->fetchSql(false)->order($this->trlOrder)->select();
    }

}
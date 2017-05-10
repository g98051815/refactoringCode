<?php
namespace AppInterFace\Model\Slide;
use AppInterFace\Model\Slide\SlideBaseModel;
use AppInterFace\Model\Slide\SlideInterFace;
class SlideResponseGroupModel extends SlideBaseModel implements SlideInterFace{



    public function response()
    {
        $where['slide_group_name']= $this->getGroupName();
        $where['slide_group_title'] = $this->getGroupTitle();
        $field = false;
        $this->where($where)->field($field)->limit($this->trlLimit)->order($this->trlOrder)->select();
    }


}
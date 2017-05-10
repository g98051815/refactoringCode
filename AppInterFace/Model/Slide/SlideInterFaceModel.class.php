<?php
namespace AppInterFace\Model\Slide;

interface SlideInterFaceModel{

    //设置组名称
    public function SetGroupName($groupName);

    /**
     * 设置组名称
    */
    public function setGroupTitle($columnName);

    /**
     * 获取数据
    */
    public function response();


}

?>
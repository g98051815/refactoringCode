<?php
namespace  AppInterFace\Model\OrderBy;

interface OrderBy{

    /**
     * 设置要排序的数据
     * @param $data [设置要排序的数据]
    */
    public function setData(&$data);


    public function OrderBy();

}

?>
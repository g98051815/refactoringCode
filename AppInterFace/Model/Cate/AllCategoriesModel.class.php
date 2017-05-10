<?php
namespace AppInterFace\Model\Cate;
use AppInterFace\Model\Cate\CateInterFaceModel;
use Think\Model;

class AllCategoriesModel extends Model implements CateInterFaceModel{

    protected $tableName="cate";
    /**
     *显示分类自上向下的遍历结果
    */

    public function response()
    {
       return $this->where(1)->select();
    }



    public function setCate($trlCate)
    {
        // TODO: Implement setCate() method.
    }


}
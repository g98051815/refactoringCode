<?php
namespace AppInterFace\Model\Cate;
use AppInterFace\Model\Cate\CateBaseModel;
use AppInterFace\Model\Cate\CateInterFaceModel;

class CateAllModel extends CateBaseModel implements CateInterFaceModel{
    //所有的数据
    private $cateAllList;

    public function response()
    {
        return $this->getAllCateTree();
    }



    public function getAllCateTree(){
        //去除所有的分类
        $this->cateAllList = $this->where(1)->select();
        $this->serializeTree($this->cateAllList);
    }

    /**
     * 将分类转换成分类树
    */
    public function serializeTree(array $list,$cid=0,$lever=0){
        $keyName = 'cate_pid';
        $key = $this->arrayTwoSearch($cid,$list,$keyName);
    }

    /**
     * 搜索二维数组
    */
    public function arrayTwoSearch($value,$array,$key){

        foreach($array as $val){
            $search = array_search($value,$val);
            if($search && $search == $key){
                return $val;
            }
        }
    }



    public function setCate($trlCate)
    {
        // TODO: Implement setCate() method.
    }

}
<?php
namespace AppInterFace\Model\Goods;
use AppInterFace\Model\Goods\CateGoodsInterFaceModel;
use AppInterFace\Model\Goods\CateLineModel;
/**
 * 通过分类id调用商品百分之百是一个列表这个是毋庸置疑的
*/
class IndexCateGoodsModel extends CateLineModel implements CateGoodsInterFaceModel{


    /**
     * 通过商品id进行调用
    */
    public function cateId($cateId){



    }

    /**
     *调用出来的数据内容百分之百是列表的数据
    */
    public function response()
    {


    }


    /**
     * 通过分类的名称去调用
    */
    public function cateName($cateName)
    {
        // TODO: Implement cateName() method.
    }


    public function tLimit($limit)
    {

    }
}
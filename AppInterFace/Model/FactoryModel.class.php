<?php
namespace AppInterFace\Model;
use Think\Model;
class FactoryModel{
    private static $objectStock = array();

    private static $stock = array();

   
    /**
     * 实例化本类的接口
    */
    static function instantiation($class){
        $replace = str_replace('./','',APP_PATH);
        $replace = str_replace('/','',$replace);
        $match = array();
        preg_match('/'.$replace.'\S*/',__DIR__,$match);
        $match = str_replace($replace,'',$match[0]);
        if(preg_match('/^\\\S*/',$class)){
            return new $class();
        }
        $class = str_replace('/','\\',$match).'\\'.$class;
        return new $class();
    }

	static function lineOrderResult(){
		if (self::verifyObject('lineOrderResult_'.get_user_info('uid'))) {
            return self::$objectStock['lineOrderResult_'.get_user_info('uid')];
        } else {
            return self::$objectStock['lineOrderResult_'.get_user_info('uid')] = new \AppInterFace\Model\Order\LineOrderResultModel();
        }
	}
	

    static function allCate(){
        if (self::verifyObject('allCate')) {
            return self::$objectStock['allCate'];
        } else {
            return self::$objectStock['allCate'] = new \AppInterFace\Model\Cate\AllCategoriesModel();

        }
    }

    /**
     * 此工厂模式必须传入调用的类
    */
    static function obServer($className){
        if(self::verifyObject('Observer_'.$className)){
            return self::$objectStock['Observer_'.$className];
        }else{
            return self::$objectStock['Observer_'.$className] = new \AppInterFace\Model\Observer\ObServerModel();
        }
    }

  /**
   * 支付宝支付接口
  */
  static function aliPay(){
      if(self::verifyObject('aliPay')){
          return self::$objectStock['aliPay'];
      }else{
          return self::$objectStock['aliPay'] = new \AppInterFace\Model\Order\LineOrderVerifyModel();
      }
  }

  //利用当前的时间戳区分订单
  static function aliPayNotify($timeSpace){
      if(self::verifyObject($timeSpace.'_'.'aliPayNotify')){
          return self::$objectStock[$timeSpace.'_'.'aliPayNotify'];
      }else{
          return self::$objectStock[$timeSpace.'_'.'aliPayNotify'] = new \Generalpay\Model\Alipay\notifyModel();
      }
  }

  /**
   * 微信支付接口
  */
  static function wxPay(){
      if(self::verifyObject('wxPay')){
          return self::$objectStock['wxPay'];
      }else{
          return self::$objectStock['wxPay'] = new \AppInterFace\Model\Order\LineOrderVerifyModel();
      }
  }


    static function lineOrderVerify(){
        if(self::verifyObject('lineOrderVerify')){
            return self::$objectStock['lineOrderVerify'];
        }else{
            return self::$objectStock['lineOrderVerify'] = new \AppInterFace\Model\Order\LineOrderVerifyModel();
        }
    }

    //订单详情
    static function lineOrderDetail(){
        if(self::verifyObject('lineOrderDetail')){
            return self::$objectStock['lineOrderDetail'];
        }else{
            return self::$objectStock['lineOrderDetail'] = new \AppInterFace\Model\Order\LineOrderDetailModel();
        }
    }
    //出游人
    static function lineOrderTravel(){
        if(self::verifyObject('lineOrderTravel')){
            return self::$objectStock['lineOrderTravel'];
        }else{
            return self::$objectStock['lineOrderTravel'] = new \AppInterFace\Model\Order\LineOrderTravelModel();
        }
    }

    //线路订单
    static function lineOrder(){
        if(self::verifyObject('lineOrder')){
            return self::$objectStock['lineOrder'];
        }else{
            return self::$objectStock['lineOrder'] = new \AppInterFace\Model\Order\LineOrderModel();
        }
    }

    static function cateAll(){
        if(self::verifyObject('cateAll')){
            return self::$objectStock['cateAll'];
        }else{
            return self::$objectStock['cateAll'] = new \AppInterFace\Model\Cate\CateAllModel();
        }
    }

    static function resultGoodsStock(){
        if(self::verifyObject('resultGoodsStock')){
            return self::$objectStock['resultGoodsStock'];
        }else{
            return self::$objectStock['resultGoodsStock'] = new \AppInterFace\Model\GoodsStock\GoodsStockModel();
        }
    }


    static function resultGoodsDocument(){
        if(self::verifyObject('resultGoodsDocument')){
            return self::$objectStock['resultGoodsDocument'];
        }else{
            return self::$objectStock['resultGoodsDocument'] = new \AppInterFace\Model\Article\ResultGoodsDocumentModel();
        }
    }

    static function resultGoodsSlidePic(){
        if(self::verifyObject('resultGoodsSlidePic')){
            return self::$objectStock['resultGoodsSlidePic'];
        }else{
            return self::$objectStock['resultGoodsSlidePic'] = new \AppInterFace\Model\ImageSpace\ResultGoodsSlidePicModel();
        }
    }

    /**
     * 商品信息
    */
    static function goodsInfo(){
        if(self::verifyObject('goodsInfo')){
            return self::$objectStock['goodsInfo'];
        }else{
            return self::$objectStock['goodsInfo'] = new \AppInterFace\Model\Goods\GoodsInfoModel();
        }
    }

    static function showCaseAuto(){
        if(self::verifyObject('showCaseAuto')){
            return self::$objectStock['showCaseAuto'];
        }else{
            return self::$objectStock['showCaseAuto'] = new \AppInterFace\Model\ShowCase\ShowCaseAutoModel();
        }
    }


    static function showCaseManual(){
        if(self::verifyObject('showCaseManual')){
            return self::$objectStock['showCaseManual'];
        }else{
            return self::$objectStock['showCaseManual'] = new \AppInterFace\Model\ShowCase\ShowCaseManualModel();
        }
    }

    /**
     *实例化橱窗接口
    */
    static function showCase(){
        if(self::verifyObject('showCase')){
            return self::$objectStock['showCase'];
        }else{
            return self::$objectStock['showCase'] = new \AppInterFace\Model\ShowCase\ShowCaseModel();
        }
    }

    static function cateSearchGoods(){

        return self::$objectStock['cateSearchGoods'] = new \AppInterFace\Model\Goods\CateSearchGoodsModel();

    }

    static function regionResponseArea(){
        if(self::verifyObject('regionResponseArea')){
            return self::$objectStock['regionResponseArea'];
        }else{
            return self::$objectStock['regionResponseArea'] = new \AppInterFace\Model\Region\RegionResponseAreaModel();
        }
    }

    /**
     *省市区集合搜索
    */
    static function regionResponse(){
        if(self::verifyObject('RegionResponse')){
            return self::$objectStock['RegionResponse'];
        }else{
            return self::$objectStock['RegionResponse'] = new \AppInterFace\Model\Region\RegionResponseModel();
        }
    }


    static function regionResponseCity(){
        if(self::verifyObject('regionResponseCity')){
            return self::$objectStock['regionResponseCity'];
        }else{
            return self::$objectStock['regionResponseCity'] = new \AppInterFace\Model\Region\RegionResponseCityModel();
        }
    }


    static function regionResponseProvince(){
        if(self::verifyObject('regionResponseProvince')){
            echo '已经存在的内容';
            return self::$objectStock['regionResponseProvince'];
        }else{
            return self::$objectStock['regionResponseProvince'] = new \AppInterFace\Model\Region\RegionResponseProvinceModel();
        }
    }


    /**
    *新建自身分类
    */
    static function cateSelf(){
        if(self::verifyObject('cateSelf')){
            echo '已经存在的内容';
            return self::$objectStock['cateSelf'];
        }else{
            return self::$objectStock['cateSelf'] = new \AppInterFace\Model\Cate\CateSelfModel();
        }
    }



    /**
    *新建子类
    */
    static function cateChild(){
          if(self::verifyObject('cateChild')){
            echo '已经存在的内容';
            return self::$objectStock['cateChild'];
        }else{
            return self::$objectStock['cateChild'] = new \AppInterFace\Model\Cate\CateChildModel();
        }
    }


    /**
     * 新建分类模型
    */
    static function Cate(){
        if(self::verifyObject('cate')){
            return self::$objectStock['cate'];
        }else{
            return self::$objectStock['cate'] = new \AppInterFace\Model\Cate\CateModel();
        }
    }


    static function slideGroupAccess(){
        if(self::verifyObject('slide_group_access')){

            return self::$objectStock['slide_group_access'];
        }else{
            return self::$objectStock['slide_group_access'] = new \AppInterFace\Model\Slide\SlideResponseGroupAccessModel();
        }
    }
    //目的地搜索商品
    static function regionSearchGoods(){
        return self::$objectStock['RegionSearchGoodsModel'] = new \AppInterFace\Model\Goods\RegionSearchGoodsModel();
    }

    static function stringToolsModel($class){
            return self::$objectStock['StringToolsModel'] = new \AppInterFace\Model\StringToolsModel();
    }


    static function slideGroup(){
        if (self::verifyObject('slide_group')) {
            return self::$objectStock['slide_group_access'];
        } else {
            return self::$objectStock['slide_group_access'] = new \AppInterFace\Model\Slide\SlideResponseGroupModel();
        }
    }



    private static function verifyObject($objectName){
        $objectStock = self::$objectStock;
        if(isset($objectStock[$objectName])){
            return true;
        }
    }






}
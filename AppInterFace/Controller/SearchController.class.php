<?php
namespace AppInterFace\Controller;
use AppInterFace\Controller\BaseController;

class SearchController extends BaseController{

    /**搜索*/
    public function SearchAction(){
        $keywords = I('get.keywords');

       // dump($keywords);
        $sort = I('get.sort');
        $limit=10;
        $page=I('get.page');
        $search = new \AppInterFace\Model\Search\SearchModel();
        //使用规则  [类型:主题游，自驾游等] [出发时间:4月,5月等] [出发地:北京、上海等] [商品名: 商品名称] [目的地:北京、上海等]
        //使用方法：
            //查询商品名称  [商品名北京]
            //查询自驾游类型 [类型自驾游]
            //查询4月份出游的商品 [出发时间4月]
            //查询目的地商品 [目的地北京]
            //联合查询的时候必须有空格可以随意调换位置  [出发时间4月 类型主题游 出发地北京 商品名北京欢乐谷 目的地北京] 叙述的是中括号里面的内容不过这个搜索功能可以进行降噪操作
        $search->setKeywords($keywords);

        //使用规则 todayNewses 今日新品  ，  synthesize  综合排序 ，sales 销量 price_asc 价格从高到底 price_desc 价格而从高到底
        $search->setSortRule($sort); //排序规则
       $search->setLimit($page,$limit);
       dump($search->search()); //页数
       dump($search->getCount()); //主题游
    }

}
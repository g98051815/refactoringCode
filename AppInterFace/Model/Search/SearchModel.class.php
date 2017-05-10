<?php
namespace AppInterFace\Model\Search;
use Think\Model;
class SearchModel extends Model{
    protected $autoCheckFields=false;
    //查询第一个关键字是 商品名称 第二个关键字是商品的目的地 第三个关键字是商品的类型 第四个关键字是旅游商品的类型 第五个关键字是适合旅行的时间
    protected $travelDate = [
        'intstrDate'=>['1','2','3','4','5','6','7','8','9','10','11','12'],//代表月份
        'strDate'=>['一','二','三','四','五','六','七','八','九','十'],//代表月份
    ];

    protected $regular=array(
                     //关键字               出发月份                   出发城市                     目的地
        'goodsName'=>'/(\x{5546}\x{54c1}\x{540d})([\x{4e00}-\x{9fa5}])+/u',
        'month'=>'/(\x{51fa}\x{53d1}\x{65f6}\x{95f4}[0-1]?[0-9]|[\x{4e00}|\x{4e8c}|\x{4e09}|\x{56db}|\x{4e94}|\x{516d}|\x{4e03}|\x{516b}|\x{4e5d}|\x{5341}])[\x{6708}]?/u',
        'origin'=>'/(\x{51fa}\x{53d1})([\x{4e00}-\x{9fa5}])+/u',
        'distination'=>'/(\x{76ee}\x{7684}\x{5730})([\x{4e00}-\x{9fa5}])+/u',
        'toggle'=>'/(\x{7c7b}\x{578b})([\x{4e00}-\x{9fa5}])+/u',
    );

    protected $travelMonth; //出游月份

    protected $origin; //出发地

    protected $distination; //目的地

    protected $goodsName; //商品名称

    protected $toggleName; //主题名称

    protected $keywords; //关键字
    //排序内容                          //今日新品                         //销量                  //综合排序                 //价格从低到高            //价格从高到底         
    protected $sortRultStock = array('todayNewses'=>'create_time desc','sales'=>'areaid desc','synthesize'=>'areaid asc','price_asc'=>'price asc','price_desc'=>'price desc');
    //排序
    protected $sortRule;
    //商品分类
    protected $ToggleStock;
    //分页
    protected $trlLimit;
    //统计数据
    protected $trlCount=0;

    public function getCount(){

        return $this->trlCount;

    }


    protected static $distinationStock=null; //目的地列表

    /**设置关键字*/
    public function setKeywords($keywords){
        $this->keywords = $keywords;
    }

    /**获取关键字*/
    public function getKeywords(){
       // dump($this->keywords);
        return $this->keywords;
    }

    /**分析关键字*/
    public function analysisKeywords(){
        $keywords = $this->getKeywords();
       // dump($keywords);
        $regular = (object)($this->regular);
        $searchParam = array();

        //产品类型
        if(preg_match($regular->toggle,$keywords,$searchParam['toggle'])){
            $this->toggleName = str_replace('类型','',$searchParam['toggle'][0]);
            //dump($this->resultThemeCate());
            $this->resultThemeCate();
        }

        //出发时间
        if(preg_match($regular->month,$keywords,$searchParam['month'])){
          
            $this->travelMonth = str_replace('月','',str_replace('出发时间','',$searchParam['month'][0]));
        }
        
        //出发地
        if(preg_match($regular->origin,$keywords,$searchParam['origin'])){
           
            $this->origin = str_replace('出发地','',$searchParam['origin'][0]);
            $this->resultDistination(); //获取目的地列表
        }

        if(preg_match($regular->goodsName,$keywords,$searchParam['goodsName'])){
            $this->goodsName = str_replace('商品名','',$searchParam['goodsName'][0]);
        }

        //目的地
        if(preg_match($regular->distination,$keywords,$searchParam['distination'])){
            $this->distination = str_replace('目的地','',$searchParam['distination'][0]);
            $this->resultDistination();
        }

    }


    public function resultThemeCate(){
        //线路商品分类表
        $where['cate_pid'] = array('eq',15);
        $this->toggleStock = M('cate')->where($where)->select();
    }

   


    /**获取目的地列表*/
    public function resultDistination(){
        $distinationStock = $this->distinationStock;
        //dump($distinationStock);
        if(!is_null($distinationStock)){
            return;
        }
        $this->distinationStock = $this->query('SELECT * FROM trl_province inner join trl_city on trl_province.provinceID = trl_city.father inner join trl_area on trl_city.cityID = trl_area.father where 1');
    }

    public function setSortRule($sortRule){

        $this->sortRule = $sortRule;

    }

    /**
    *分页
    */
    public function setLimit($page=1,$limit=10){
        if($page <= 1 || empty($page)){
            $this->trlLimit =  $limit;
        }else{
            $this->trlLimit = ($page*$limit)-$limit.','.$limit;
        }
    }



    public function search(){
        $this->analysisKeywords(); //关键字分析
        $where= array();
        if(!empty($this->travelMonth)){
            //$where['eq'] = array();
             $where['purchase'] = array('like','%'.$this->travelMonth.'%');
        }

        /**判断商品类型*/
        if(!empty($this->toggleName)){
            foreach($this->toggleStock as $val){
                if(strstr($val['cate_name'],$this->toggleName)){
                    $where['line_type'] = array('eq',$val['cid']);
                    break;
                }   
            }
        }

        if(!empty($this->$origin)){
            $where['startcity'] = array('in',$this->getDistination($this->$origin));
        }

        if(!empty($this->distination)){
            $where['areaid'] = array('in',$this->getDistination($this->distination));
        }

        if(!empty($this->goodsName)){
            $where['name'] = array('like','%'.$this->goodsName.'%');
        }

        if(empty($where)){
            if(!empty($this->getDistination($this->getKeywords()))){
                 $where['areaid'] = array('in',$this->getDistination($this->getKeywords()));
            }
            //最终使用的方法
            $where['name'] = array('like','%'.$this->getKeywords().'%');
        }
        $result = $this->table('trl_line')->where($where)->fetchSql(false)->order($this->sortRultStock[$this->sortRule])->limit($this->trlLimit)->select();
       
        //dump($result);
        $this->trlCount = $this->table('trl_line')->where($where)->count();
        return $result;
    }

    /**
    *获取目的地
    */
    public function getDistination($distinationName=null,$filter='code'){
        $distinationStock = $this->distinationStock;
        $filterStock['code'] = ['areaid','provinceid','cityid'];
        $filterStock['name'] = ['area','province','city'];
        if(is_null($distinationStock)){
            $this->resultDistination(); //获取目的地
        }
        
        if(is_null($distinationName)){
            return $distinationStock;
        }else{
            $count = count($this->distinationStock)/2;
            $j = count($this->distinationStock)+1;
            $result = array();
            for($i=0; $i<$count; $i++){ 
                 $j--;
                 $ret = $this->distinationStock[$i];
                 $rev = $this->distinationStock[$j];
                     //匹配到省份的名称
                if(strstr($ret['province'],$distinationName) || strstr($ret['city'],$distinationName) || strstr($ret['area'],$distinationName)){
                    $result[] = $ret;
                }
                
                if(strstr($rev['province'],$distinationName) || strstr($rev['city'],$distinationName) || strstr($rev['area'],$distinationName)){
                     $result[] = $rev;
                }
             
            }
              $response = array();
               foreach($result as $val){
                   foreach($filterStock[$filter] as $filterValue){
                       $response[] = $val[$filterValue];
                   }
               }
               return array_unique($response);
        }
}


    public function setTravelMonth($month){
        $this->travelMonth = $month;
    }

}
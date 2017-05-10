<?php
namespace AppInterFace\Model\ShowCase;
use AppInterFace\Model\FactoryModel;
use AppInterFace\Model\ShowCase\ShowCaseBaseModel;

class ShowCaseModel extends ShowCaseBaseModel{

    protected $tableName = 'showcase';

    private $showCaseName;  //名称

    private $showCaseTitle; //标题

    private $showCasePortSign; //显示端口

    private $showCaseSmallTitle;  //小标题

    private $showCaseRule; //初始化规则,只有在查询的时候才会进行初始化规则



    /**
     * 获取列表和属性
     * 这个方法中获取的是单条列表
     * @param [可以是橱窗的名字也可以橱窗的id]
     * @return array [此方法返回的单条数据]
    */
    public function resultAndRule($param){
        /**
         * 判断获取到的是否为数字如果是数字的话那么就行id的检索
        */
        if(is_numeric($param)){
            $where[$this->dbConfig['SHOWCASE'].'.id'] = array('eq',$param);
        }else{
            $where[$this->dbConfig['SHOWCASE'].'.name'] = array('eq',$param);
        }
       return $this->where($where)->field(false)->
        join('__SHOWCASE_RULE__ ON __SHOWCASE__.id = __SHOWCASE_RULE__.showcase_id')->
        find();

    }

    /**
     * 获取橱窗的列表
    */
    public function resultList(){
        //获取橱窗列表
        return $this->select();
    }


    /**
     * 设置橱窗名称
     * 这个方法中设置的是橱窗的名称
     * @param $name [橱窗的名称]
    */
    public function setShowCaseName($name){
        if(empty($name)):
            echo '橱窗名称不能为空！';
            exit();
        endif;
        $where['name'] = array('eq',$name);
        $count = $this->where($where)->count();
        //判断名字是否存在，如果存在那么就调用规则
        if(count($count)>0){
            //查询以及设置规则
            $rule = $this->resultAndRule($name);
            $this->showCaseRule = $rule;
        }
        $this->showCaseName = $name;
    }


    /**
     * 查询橱窗中推荐的商品列表
    */
    public function response(){
       $showCaseType = $this->getShowCaseRule('showcase_type');
       //自动的查询规则
       if($showCaseType == 'manual'){
            //手动的查询规则
           $this->setObject(FactoryModel::showCaseManual());
       }

       /**
        * 自动查询的规则
       */
       if($showCaseType == 'auto'){

           $this->setObject(FactoryModel::showCaseAuto());

       }

       $this->trlData->setShowCaseId($this->getShowCaseRule('id'));
       return $this->trlData->response();
    }


    /**
     *获取显示规则
     * @param $ruleKey [显示规则的键]
     * @return bool|string 返回详细的规则
     */
    public function getShowCaseRule($ruleKey){
        $rule = $this->showCaseRule;
        if(empty($rule)){
            $this->error = '规则是空的无法查询！';
            return false;
        }

        if(!array_key_exists($ruleKey,$rule)){
            $this->error ='搜索的键不存在！';
            return false;
        }
        return $rule[$ruleKey];
    }




}
<?php
namespace AppInterFace\Model\ShowCase;
use Think\Model;

class ShowCaseBaseModel extends Model{

    protected $dbConfig;

    protected $trlData; //新建的策略模式

    public function _initialize(){
        //设置关联的数据库
        $this->dbConfig['SHOWCASE'] = 'trl_showcase';

        $this->dbConfig['RULE'] = 'trl_showcase_rule';

        $this->dbConfig['MENUS'] = 'trl_showcase_menus';

        $this->dbConfig['CONTENTS'] = 'trl_showcase_contents';

    }

    /**
     * 设置操作对象
    */
    protected function setObject($object){
        $this->trlData = $object;
    }







}
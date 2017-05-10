<?php
namespace AppInterFace\Model;

class StringToolsModel{

    private $caller;


    public function is($condition){

        /**
         *判断是否要调用多个分类
         */
        if(preg_match('/[0-9]+,[0-9]+\b/',$condition)){

            $where = $this->_afterNumericMore($condition);

        }


        if(preg_match('/[^0-9]+,[^0-9]+\S+/',$condition)){

            $where = $this->_afterStringMore($condition);

        }


        if(is_numeric($condition)){

           $where = $this->_afterNumeric($condition);
        }


        if(!is_numeric($condition) && !preg_match('/[^0-9]+,[^0-9]+\S+/',$condition) && !preg_match('/[0-9]+,[0-9]+\b/',$condition)){

           $where = $this->_afterString($condition);

        }
        return $where;
    }


    /**
     * 需要返回方法
    */
    protected function _afterString($condition){

        return $this->caller->_afterString($condition);
    }

    /**
     * 需要返回方法
    */
    protected function _afterStringMore($condition){

        return $this->caller->_afterStringMore($condition);
    }

    /**
     * 需要返回方法
    */
    protected function _afterNumeric($condition){

        return $this->caller->_afterNumeric($condition);

    }

    /**
     * 需要返回方法
    */
    protected function _afterNumericMore($condition){

        return $this->caller->_afterNumericMore($condition);

    }


    public function _afterOperation($caller){
        $this->caller = $caller;
    }

}

?>
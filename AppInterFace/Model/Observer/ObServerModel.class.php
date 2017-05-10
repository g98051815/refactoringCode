<?php
namespace AppInterFace\Model\Observer;
use AppInterFace\Model\Observer\ObServerInterFaceModel;

class ObServerModel implements ObServerInterFaceModel{

    private $obServerStock; //观察者调用栈
    /**
     * @param $observer [观察者对象];
     * @param $params [观察者对象接收的参数]
    */
    public function addObServer($observer,$params)
    {
        $this->obServerStock[] = ['OBSERVER'=>$observer,'PARAMS'=>$params,'MD5'=>md5(get_class($observer)),'SHA1'=>sha1(get_class($observer))];
    }


    public function removeObServer($observer){
        foreach( $this->obServerStock as $key => $val){
            if(strcmp(sha1(get_class($observer)),$val['SHA1'])==0 && strcmp(md5(get_class($observer)),$val['MD5']) == 0){
                unset($this->obServerStock[$key]);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getObServerStock()
    {
        return $this->obServerStock;
    }

    //通知
    public function notify()
    {
       $stock = $this->obServerStock;
       foreach($stock as $val){
            $val['OBSERVER']->setParams($val['PARAMS']);
            $val['OBSERVER']->receive();
       }
    }

}
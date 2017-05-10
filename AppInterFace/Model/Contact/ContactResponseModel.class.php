<?php
namespace AppInterFace\Model\Contact;
use Think\Model;

class ContactResponseModel extends Model{

    protected $tableName = 'contarct';

    protected $uid; //当前用户的id

    public function _initliaze(){
        $this->uid = get_user_info('uid');
    }

    public function response(){
       $where['uid'] = array('eq',$this->getUid());
       $response = $this->where($where)->select();
       return $response;
    }

    public function setUid($uid){
      $this->uid = $uid;
      return $this;
    }

    public function getUid(){
      return $this->uid;
    }

}

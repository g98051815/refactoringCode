<?php
namespace AppInterFace\Controller;
use Think\Controller;

use Admin\Model\Message\messageModel;

use AppInterFace\Model\FactoryModel;
/**
 *
*/
class BaseController extends Controller{
	
	protected $trlAppId = '01021132125';
	
	protected $trlToken = 'e5261432';
	
	protected $appVerify = false;
    
    protected $trlTrimData = array(); //去除空格使用
    
    public function _initialize(){
    	//验证token
    	$passport = I('');
    	$appid = $passport['appid'];
    	$token = $passport['token'];
    	
    	if(!$appVerify){
    		return true;
    	}
    	
    	if(strcmp($appid,$this->trlAppId)){
    		messageModel::errorMsg('appid is error');
    	}
    	
    	if(strcmp($token,$this->trlToken)){
    		messageModel::errorMsg('token is error');
    	}
    }
    
    /**
     * 去除输入内容左右的空格
     * */
    public function clearTrim($trimData){
    	foreach($trimData as &$val){
    		if(is_array($val)){
    			foreach($val as &$value){
    				$value = trim($value);
    			}
    		}else{
    			$val = trim($val);
    		}
    	}
    	return $trimData;
    }
    
    public function IndexAction(){

    }



    /**
     * 默认是新建列表
     */
    public function setObject($responseType){

        $this->trlData = $responseType;
    }

}

?>
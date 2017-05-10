<?php
namespace AppInterFace\Controller;
use Think\Controller;
class ContactController extends Controller{

    public function indexAction(){
        $contact = new \AppInterFace\Model\Contact\ContactResponseModel();
    }

    //用户已经登录的情况下查询用户列表
    public function responseContactAtLoginAction(){
        $contact = new \AppInterFace\Model\Contact\ContactResponseModel();
        $response = $contact->setUid(3)->response();
        if(IS_AJAX){
            $this->ajaxReturn($response);
        }

        if(IS_GET){
            echo serialize($response);
        }
    }

}

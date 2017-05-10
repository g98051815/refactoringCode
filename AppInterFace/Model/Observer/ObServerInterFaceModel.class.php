<?php
namespace AppInterFace\Model\Observer;

interface ObServerInterFaceModel{

    //添加观察者
    public function addObServer($observer,$params);

    //通知观察者
    public function notify();

}
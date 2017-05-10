# refactoringCode
这个是我曾经重构过的模块
##我的设计思路
第一是在Model模块下建立工厂类FactoryModel实例化类,这样可以避免方法更改带来的麻烦。<br />
其中主要重构订单模块就是Order文件夹下的，模块下分为四个类<br />
1. LineOrderBaseModel //订单基础模类
2. LineOrderDetailModel //订单内容类
3. LineOrderModel //订单类
4. LineOrderResultModel //订单获取类
5. LineOrderTravelModel //订单出行人类
6. LineOrderVerifyModel //订单验证类

 其中所有的订单都继承在LineOrderBaseModel下 <br />
 LineOrderBaseModel 负责初始化和生成订单编号。 <br />
 LineOrderModel 生成订单的类继承于LineOrderBaseModel 直接获取自动生成的订单编号。 <br />
 LineOrderVerifyModel 订单验证类，在LineOrderModel中对其进行调用，这样做可以自由扩展验证条件，以及验证类。 <br />
 //最后生成定单通知订单信息模块以及出行人模块 <br />
 LineOrderDetailModel //订单信息模块 <br />
 LineOrderTravelModel //订单出行人信息模块 <br />
 这样做可以保证系统的可用性以及扩展性。 <br />

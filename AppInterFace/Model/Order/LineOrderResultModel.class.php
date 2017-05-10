<?php
namespace AppInterFace\Model\Order;
use AppInterFace\Model\Order\LineOrderBaseModel;

class LineOrderResultModel extends LineOrderBaseModel{
	
	protected $generateOrderNo = false;
	
	protected $tableName = 'line_order';
	
	protected $trlWhere=array();
	
	protected $trlLimit=0;
	
	protected $trlDbConfig =['ORDER'=>'line_order','DETAIL'=>'line_order_detail','TRAVEL'=>'line_order_travel','LINE'=>'line'];
	public function response(){
		$db = $this->trlDbConfig;
		$where = $this->getWhere();
		$limit = $this->getLimit();
		$line_order_fields = $this->getDbFields();
		array_walk($line_order_fields,array($this,'popAndTrl'),array('popKey'=>['id'],'tableName'=>'trl_'.$db['ORDER']));
		$line_order_detail_fields = M($db['DETAIL'])->getDbFields();
		array_walk($line_order_detail_fields,array($this,'popAndTrl'),array('popKey'=>['id'],'tableName'=>'trl_'.$db['DETAIL']));
		$line_order_travel_fields = M($db['TRAVEL'])->getDbFields();
		array_walk($line_order_travel_fields,array($this,'popAndTrl'),array('popKey'=>['id'],'tableName'=>'trl_'.$db['TRAVEL']));
		$line_fields = M($db['LINE'])->getDbFields();
		array_walk($line_fields,array($this,'popAndTrl'),array('popKey'=>['status','introduce','price','productnumber',
		'desc','ordernumber','startime','endtime','keywords','line_type','small_one','small_two','small_three','small_four','slidepic','create_time','cid','child_type'],'tableName'=>'trl_'.$db['LINE']));
		$field = array_merge($line_order_fields,$line_order_detail_fields,$line_order_travel_fields,$line_fields);
		$field = array_filter($field);
		$result = $this->where((empty($where)? 1 : $where))->join('__LINE_ORDER_DETAIL__ ON __LINE_ORDER__.order_no = __LINE_ORDER_DETAIL__.order_no')
		->join('__LINE_ORDER_TRAVEL__ ON __LINE_ORDER__.order_no =  __LINE_ORDER_TRAVEL__.order_no')
		->limit($limit)->field($field)->group('trl_'.$db['ORDER'].'.order_no')->order('create_time desc')->join('__LINE__ ON __LINE_ORDER__.goods_id = __LINE__.id')->select();
		return $result;
	}

	public function popAndTrl(&$val,$key,$condition){
		 if(is_array($condition['popKey'])){
			if(false !== array_search($val,$condition['popKey'])){
				$val = '';
				return;
			}
		 }
		 $val = $condition['tableName'].'.'.$val;
	}
	
	/**
	 * 设置订单编号
	 * */
	public function setOrderNoFix($orderNo){
		$this->trlWhere[$this->getTableName().'.order_no'] = array('eq',$orderNo);
		
	}
	
	
	public function setUid($userId){
		$this->trlWhere[$this->getTableName().'.uid'] = array('eq',$userId);
	}
	
	
	public function setLimit($limit){
		
		$this->trlLimit = $limit;
		
	}

	public function setOrderStatus($status=null){
		switch($status){
			case 'untravel': //待出行
				$status = '3';
				break;
			case 'unpay':
				$status = '2';
				break;
			case 'complete':
				$status = '1';
				break;
			case 'closed':
				$status = '0';	
				break;
		}
		if(is_null($status)){return;}
		$this->trlWhere['trl_line_order'.'.status'] = array('eq',$status);
	}
	
	public function getLimit(){
		
		return $this->$trlLimit;
		
	}
	
	public function getWhere(){
		return $this->trlWhere;
	}
	
	/**
	 * 获取订单编号
	 * */
	public function getOrderNo(){
		
		return $this->trlOrderNo;
	}
	
	
}
?>
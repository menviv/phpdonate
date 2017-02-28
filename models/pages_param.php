<?php
class Pages_param extends AppModel {
	var $name = 'Pages_param';
	function getPageParams($page_id){
		if($list = $this->find("list",array("conditions"=>"page_id='$page_id'","fields"=>array("key","value")))){
			return $list;
		}
		else{
			return array();
		}
	}
}
?>
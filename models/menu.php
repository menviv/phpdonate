<?php
class Menu extends AppModel {
	var $name = 'Menu';
	function getMenu($type="",$options=array()){
		$cond = "(parent_id=0 or parent_id Is Null)";
		if(!empty($type))
			$cond .= " and type='$type'";
		if(isset($options['page_connected_id']))
			$cond .= " and page_connected_id='".$options['page_connected_id']."'";
		if(!isset($options['lang']))
			$options['lang'] = "he";
		$cond .= " and lang='".$options['lang']."'";
		if(!isset($options['inner']))
			$this->bindParams("hasMany","Inner","Menu","","position asc","","parent_id");
		$optionsFind = array("conditions"=>$cond,"order"=>"position asc");
		if(isset($options['fields']))
			$optionsFind['fields'] = $options['fields'];
		return $this->find("all",$optionsFind);
	}
	function getParentIdOfMenuLink($menuLink){
		if($menuLink=="/")
			return 0;
		if($found=$this->find("link='$menuLink' and page_id IS NOT NULL","id,parent_id,page_connected_id")){
			return $found['Menu'];
		}else{
			return 0;
		}
	}
	function getMenuHeaderSel($page_connected){
		if($found=$this->find("page_id='$page_connected'","position")){
			return $found['Menu']['position'];
		}else{
			return 0;
		}
	}
}
?>
<?php
class Page extends AppModel {
	var $name = 'Page';
	function getPageByLink($link){
		if($page = $this->find("link='$link'")){
			$this->Pages_param = & new Pages_param;
			$page['Pages_param'] = $this->Pages_param->getPageParams($page['Page']['id']);
			return $page;
		}
		return false;
	}
	function getPageLinkByType($type){
		if($page = $this->find("type='$type'","link,pname")){
			return $page['Page'];
		}
		return false;
	}
}
?>
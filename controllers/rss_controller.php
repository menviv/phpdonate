<?php
class RssController extends AppController{
	var $name = 'Rss';
	var $components = array("Session","Mail");
	var $uses = array("Page");
	var $helpers = array("Time");
	function beforeFilter(){
		parent::beforeFilter();
	}
	function rss(){
		$list = $this->Page->find("all",array("conditions"=>"type='article' or type='event'","order"=>"dateAdd desc"));
		$this->set("items",$list);
		header('Content-type: text/xml');
		echo $this->render("rss","emptyLayout");
		die();
	}
}
?>
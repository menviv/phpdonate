<?php
class SitemapsController extends AppController{
    var $name = 'Sitemaps';
    var $uses = array('Page');
    var $helpers = array('Time');
    var $components = array('RequestHandler');
    function beforeFilter(){
    	
    }
    function index (){
    	header('Content-type: text/xml');
        $this->set('pages', $this->Page->find('all', array('conditions'=>"type!='home' and type!='search'",'fields' => array('id','link','lastUpdate',"dateAdd"))));
		//debug logs will destroy xml format, make sure were not in drbug mode
		Configure::write ('debug', 0);
		echo $this->render("index","emptyLayout");
		die();
    }
}
?>
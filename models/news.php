<?php
class News extends AppModel {
	var $name = 'News';
	function getNews($perPage,$page){
		if($news = $this->find("all",array("order"=>"position asc","limit"=>$perPage,"page"=>$page)))
			return $news;
		else
			return array();
	}
}
?>
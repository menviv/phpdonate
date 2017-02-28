<?php
class FunctionsView extends View {
	function maxchars($item, $max) {
	    $fwords = array("'<br>'", "'<br />'");
	    $rwords = array(" ", " ");
	    $item = preg_replace($fwords, $rwords, $item );
	    if (strlen($item) <= $max) return $item;
	    return strrev(strstr(strrev(substr($item, 0, $max)), ' ')) . '...';
	}
	function secToFormat($num_secs){
		$str = '';
		$minutes = intval(((intval($num_secs) / 60) % 60));
		if ($minutes < 10) $str .= '0';
			$str .= $minutes.':';
		$seconds = intval(intval(($num_secs % 60)));
		if ($seconds < 10) $str .= '0';
			$str .= $seconds;
		return $str;
	}
	function secToMins($num_secs){
		return intval((intval($num_secs) / 60));
	}
	function replaceItem($content=""){
		/*$changeTo = '<iframe width="480" height="274" src="http://www.youtube.com/embed/\1" frameborder="0" allowfullscreen></iframe>';
		$content = preg_replace('/<img class="mceItem".*alt="(.*?)".*?>/',$changeTo,$content);
		*/
		$changeTo = '<iframe width="\2" height="\3" src="http://www.youtube.com/embed/\1" frameborder="0" allowfullscreen></iframe>';
		$content = preg_replace('/<img class="mceItem".*alt="(.*?)".*?.*width="(.*?)".*?.*height="(.*?)".*?>/',$changeTo,$content);
		
		$changeTo = '<iframe width="480" height="274" src="http://www.youtube.com/embed/\1" frameborder="0" allowfullscreen></iframe>';
		$content = preg_replace('/<img class="mceItem".*alt="(.*?)".*?>/',$changeTo,$content);
		
		
		//preg_match_all("/%itemElement[0-9\(\)+.\- ]%/s",$content,$out);
		preg_match_all("/%itemElement\d{0,10}%/s",$content,$out);
		$items = array();
		foreach($out[0] as $element):
			$id = str_replace("%itemElement","",$element);
			$id = str_replace("%","",$id);
			if(!in_array($id,$items))
				$items[] = $id;
		endforeach;
		if(!empty($items)){
			$this->Item = & new Item;
			$array = "(".implode(",",array_values($items)).")";
			$founds = $this->Item->find("all",array("conditions"=>"id IN $array"));
			foreach($founds as $itemFound):
				if($itemFound['Item']['type']=="image")
					$elementToRender = "imageitem";
				if($itemFound['Item']['type']=="video")
					$elementToRender = "videoitem";
				if(isset($elementToRender))
					$replace[$itemFound['Item']['id']] = $this->element("../elements/$elementToRender",array("item"=>$itemFound));
			endforeach;
			$arrayOfIds = array_values($items);
			foreach($arrayOfIds as $itemReplace):
				$content = str_replace("%itemElement$itemReplace%",$replace[$itemReplace],$content);
			endforeach;
		}
		return $content;
	}
}
?>
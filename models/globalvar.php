<?php
class Globalvar extends AppModel {
	var $name = 'Globalvar';
	function replace($replaceKey,$replaceArray){
		$data=$this->find("Globalvar.key='$replaceKey'");
		foreach ($replaceArray as $key=>$value):
			$data['Globalvar']['value'] = str_replace($key,$value,$data['Globalvar']['value']);
		endforeach;
		return $data['Globalvar']['value'];
	}
	function getSetting($key){
		if($sitesettings = $this->find("Globalvar.key='$key'")){
			return $sitesettings['Globalvar']['value'];
		}
		else
			return false;
	}
}
?>
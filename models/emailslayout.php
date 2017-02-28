<?php
class Emailslayout extends AppModel {
	var $name = 'Emailslayout';
	function replace($replaceKey,$replaceArray){
		$data=$this->find("Emailslayout.key='$replaceKey'");
		foreach ($replaceArray as $key=>$value):
			$data['Emailslayout']['textvalue']=str_replace($key,$value,$data['Emailslayout']['textvalue']);
		endforeach;
		return $data['Emailslayout']['textvalue'];
	}
	function replaceById($id,$replaceArray){
		$data = $this->find("Emailslayout.id='$id'");
		foreach ($replaceArray as $key=>$value):
			$data['Emailslayout']['textvalue']=str_replace($key,$value,$data['Emailslayout']['textvalue']);
		endforeach;
		return $data['Emailslayout']['textvalue'];
	}
	function getDetails($replaceKey){
		$data=$this->find("Emailslayout.key='$replaceKey'");
		return $data['Emailslayout'];
	}
}
?>
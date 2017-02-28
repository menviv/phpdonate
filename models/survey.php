<?php
class Survey extends AppModel {
	var $name = 'Survey';
	function getLastSurvey(){
		$data = $this->find("","","dateAdd desc");
		return $data;
	}
}
?>
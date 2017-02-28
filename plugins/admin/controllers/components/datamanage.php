<?php
class DatamanageComponent extends Object {
	var $controller = true;
	var $cond = "";
	var $orderBy = "";
	var $PageType = "index";
	/**
	 * This method takes a reference to the controller which is loading it.
	 * Perform controller initialization here.
	 *
	 * @param unknown_type $controller
	 */
	function startup(&$controller)
	{
		$this->controller = $controller;
		$this->loadSettings();
		//$this->configs = loadDataManageVars();
	}
	/**
	 * generate the list data.
	 *
	 * @param string $model
	 * @param int $page
	 */
	function generateList($model,$page=1){
		$this->$model = & new $model;
		$arrayOfFields = $this->loadFieldsFromXml($this->configs->xml_folder."/".$this->configs->models_xml_folder."/".$model.".xml");
		$data = $this->$model->find("all",array("conditions"=>$this->cond,"order"=>$this->orderBy,"limit"=>$this->configs->items_per_page,"page"=>$page));
		if(isset($arrayOfFields['Items'][$model]['toptitle'])){
			if(isset($this->toptitle))
				$this->controller->set("topTitle",$this->toptitle);
			else
				$this->controller->set("topTitle",$arrayOfFields['Items'][$model]['toptitle']);
			unset($arrayOfFields['Items'][$model]['toptitle']);
		}
		$this->controller->set("arrayOfFields",$arrayOfFields['Items'][$model]);
		$this->controller->set("data",$data);
		$this->controller->set("model",$model);
		$count = $this->$model->find("count",array("conditions"=>$this->cond));
		if(!empty($this->configs->items_per_page))
			$counts = ceil($count/$this->configs->items_per_page);
		else
			$counts = 0;
		$this->controller->set("current",$page);
		$this->controller->set("rows",$counts);
		$this->controller->set("sizeof",$count);
		if(isset($arrayOfFields['Items']['Search']))
			$this->controller->set("searchFields",$arrayOfFields['Items']['Search']['Fields']);
		else
			$this->controller->set("searchFields",array());
		$this->loadrelation($model);
		$this->loadSelects($model);
		$this->getTabs($model,"list");
	}
	function generateForm($model,$type="new",$id=""){
		$this->$model = & new $model;
		$this->loadrelation($model);
		
		$arrayOfFields = $this->loadFieldsFromXml($this->configs->xml_folder."/".$this->configs->models_xml_folder."/".$model.".xml");
		if(isset($arrayOfFields['Items']['Once'])){
			$selects = $this->loadSelects($model,true);
			foreach($arrayOfFields['Items']['Once'] as $oncekey=>$oncevalue):
				if(isset($oncevalue['Item'])){
					$onceArray = array_keys($oncevalue['Item']);
					switch($oncekey){
						case "Type":
							$list = $this->Page->find("list",array("fields"=>array('type', 'id')));
							if($type=="edit"){
								$PageType = $this->Page->getValue("Page",$id,"type");
							}
							foreach($onceArray as $onceArrayItem):
								if(isset($list[$onceArrayItem])){
									if($type=="edit"){
										if($PageType!=$onceArrayItem)
											unset($selects['Type'][$onceArrayItem]);
									}else{
										unset($selects['Type'][$onceArrayItem]);
									}
								}
							endforeach;
							break;
					}
				}
			endforeach;
			$this->controller->set("selects",$selects);
		}else{
			$this->loadSelects($model);
		}
		if($model=="Menu"){
			if(isset($_GET['type']) and $_GET['type']=="category"){
				unset($arrayOfFields['Items']['MenuNew']['Item']['Type']);
				//unset($arrayOfFields['Items']['MenuNew']['Item']['PageId']);
				unset($arrayOfFields['Items']['MenuNew']['Item']['Link']);
			}
		}
		if(isset($arrayOfFields['Items']['Require']['Fields'])){
			$this->controller->set("RequireFields",$arrayOfFields['Items']['Require']['Fields']);
		}
		if(isset($arrayOfFields['Items']['Ajaxload'])){
			$this->controller->set("ajaxLoad",$arrayOfFields['Items']['Ajaxload']);
		}
		if(isset($arrayOfFields['Items'][$model."Connection"])){
			foreach($arrayOfFields['Items'][$model."Connection"] as $connectionkey=>$connectionvalue):
				$connectionkeyUnderscore = inflector::underscore($connectionkey);
				$connectionField = $connectionvalue['Item']['xmlField'];
				if($type=="edit"){
					$keyValue = $this->$model->getValue($model,$id,$connectionkeyUnderscore);
					$cond = "id='$keyValue'";
					if(isset($this->$connectionvalue['Item']['condition'])){
						$cond = " and ".$this->$connectionvalue['Item']['condition'];
					}
					if($connectionDataFound = $this->$connectionvalue['Item']['model']->find($cond)){
						$connectionData = $connectionDataFound[$connectionvalue['Item']['model']];
						$connectionData[$connectionkeyUnderscore] = $connectionData['id'];
						unset($connectionData['id']);
					}
				}else{
					
				}
			endforeach;
		}
		if(isset($connectionField))
			$arrayOfFieldscheck = $arrayOfFields['Items'][inflector::camelize($connectionField)];
		else 
			$arrayOfFieldscheck = $arrayOfFields['Items'][inflector::camelize($model."_new")];
		if(in_array($model,$this->configs->pagesParamsModels)){
			if($model=="Page"){
				$return = $this->loadPagesParams(array("Page"=>array("type"=>$this->PageType)),$arrayOfFieldscheck);
				$arrayOfFieldscheck = $return['arrayOfFieldscheck'];
			}
			else{
				$return = $this->loadPagesParams(array("Page"=>array("type"=>inflector::underscore($model))),$arrayOfFieldscheck);
				$arrayOfFieldscheck = $return['arrayOfFieldscheck'];
			}
		}
		if(isset($arrayOfFieldscheck['Item']))
			$arrayOfFieldssave = $arrayOfFieldscheck['Item'];
		if(isset($arrayOfFields['Items'][inflector::camelize($model."_stages")])){
			$stages = $arrayOfFields['Items'][inflector::camelize($model."_stages")]['Item'];
			$this->controller->set("stages",$stages);
		}
		if(isset($arrayOfFieldscheck['toptitle']))
			$this->controller->set("topTitle",$arrayOfFieldscheck['toptitle']);
		if(isset($arrayOfFields['Items']['Remove'])){
			if(isset($arrayOfFields['Items']['Remove'][inflector::camelize($this->PageType)])){
				foreach ($arrayOfFields['Items']['Remove'][inflector::camelize($this->PageType)] as $fkey=>$fvalue):
					unset($arrayOfFieldssave[0][inflector::camelize($fkey)]);
				endforeach;
			}
		}
		$this->controller->set("arrayOfFields",$arrayOfFieldssave);
		$this->controller->set("model",$model);
		if($type=="edit"){
			if(isset($arrayOfFieldscheck['edittitle']))
				$this->controller->set("topTitle",$arrayOfFieldscheck['edittitle']);
			$data = $this->$model->findById($id);
			if(isset($connectionData)){
				$dataSave =	array_merge($data[$model],$connectionData);
				unset($data);
				$data[$model] = $dataSave;
			}
			if(isset($this->configs->fieldsType[$model]) and in_array("date",array_values($this->configs->fieldsType[$model]))){
				foreach($this->configs->fieldsType[$model] as $configKey=>$configValue):
					switch ($configValue){
						case "date":
							if(!empty($data[$model][$configKey])){
								$newValue = explode(" ",$data[$model][$configKey]);
								$new = explode("-",$newValue[0]);
								$data[$model][$configKey] = $new[2]."-".$new[1]."-".$new[0];
								$data[$model][inflector::underscore($configKey)] = $new[2]."-".$new[1]."-".$new[0];
							}
							break;
					}
				endforeach;
			}
			if($model=="Page"){
				$newReturn = $this->loadPagesParams($data,$arrayOfFieldscheck);
				$arrayOfFieldscheck = $newReturn['arrayOfFieldscheck'];
				$data = $newReturn['data'];
			}
			if(isset($arrayOfFieldscheck['Item']))
				$arrayOfFieldssave = $arrayOfFieldscheck['Item'];
			if(isset($arrayOfFields['Items']['Remove'])){
				if(isset($arrayOfFields['Items']['Remove'][inflector::camelize($this->PageType)])){
					foreach ($arrayOfFields['Items']['Remove'][inflector::camelize($this->PageType)] as $fkey=>$fvalue):
						unset($arrayOfFieldssave[0][inflector::camelize($fkey)]);
					endforeach;
				}
			}
			$this->controller->set("arrayOfFields",$arrayOfFieldssave);
			$this->controller->set("edit_id",$id);
			$this->controller->data=$data;
			if(isset($data[$model]['password']))
				$this->controller->data[$model]['password']="";
		}
		if($model=="Page")
			$this->getTabs(inflector::camelize($this->PageType),"edit");
		else
			$this->getTabs($model,"edit");
	}
	function loadPagesParams($data,$arrayOfFieldscheck){
		$this->Pages_param = & new Pages_param;
		if(isset($this->configs->pagesParams) and $this->configs->pagesParams and isset($data['Page']['id']))
			$data['Page'] = array_merge($data['Page'],$this->Pages_param->getPageParams($data['Page']['id']));
		
		if(isset($this->configs->pagesParams) and $this->configs->pagesParams){
			$pagesParams =  $this->loadFieldsFromXml($this->configs->xml_folder."/".$this->configs->xml_pagesParams);
			if(isset($arrayOfFieldscheck['Item'][0])){
				if(isset($pagesParams['Items'][inflector::camelize($data['Page']['type'])]))
					$arrayOfFieldscheck['Item'][0] = array_merge($arrayOfFieldscheck['Item'][0],$pagesParams['Items'][inflector::camelize($data['Page']['type'])]);
			}
			else{
				if(isset($pagesParams['Items'][inflector::camelize($data['Page']['type'])]))
					$arrayOfFieldscheck['Item'] = array_merge($arrayOfFieldscheck['Item'],$pagesParams['Items'][inflector::camelize($data['Page']['type'])]);
			}
		}
		$newArray['data'] = $data;
		$newArray['arrayOfFieldscheck'] = $arrayOfFieldscheck;
		return $newArray;
	}
	function getTabs($model,$type){
		$arrayOfFields = $this->loadFieldsFromXml($this->configs->xml_folder."/tabs.xml");
		if(isset($arrayOfFields['Items'][$model][inflector::camelize($type)]['Item'])){
			$this->controller->set("innerTabs",$arrayOfFields['Items'][$model][inflector::camelize($type)]['Item']);
		}
	}
	/**
	 * load selects variables for data edit and new data.
	 *
	 * @param unknown_type $model
	 */
	function loadSelects($model,$return=false){
		$selects = $this->loadFieldsFromXml($this->configs->xml_folder."/".$this->configs->xml_selects);
		$seletArray = array();
		if(isset($selects['Items'][$model]))
			$seletArray = $selects['Items'][$model];
		if($return)
			return $seletArray;
		else
			$this->controller->set("selects",$seletArray);
	}
	/**
	 * load relation between two different tables.
	 *
	 * @param string $model
	 */
	function loadrelation($model){
		$relation =  $this->loadFieldsFromXml($this->configs->xml_folder."/".$this->configs->xml_relation);
		if(isset($relation['Items'][$model])){
			$relations = $relation['Items'][$model];
			foreach ($relations as $key=>$value):
				$modelrelation = $value['model'];
				$this->$modelrelation = & new $modelrelation;
				$list = $this->$modelrelation->find("list",array('fields' => array(str_replace('{n}.','',"$modelrelation.id"), str_replace('{n}.','',$modelrelation.".".$value['foreignKey']))));
				$this->controller->set($key,$list);
			endforeach;
		}
	}
	/**
	 * parse the fields from xml
	 *
	 * @param string $file_name
	 * @return array of parsed xml
	 */
	function loadFieldsFromXml($file_name){
	    // import XML class
	    App::import('Xml');
	    // now parse it
	    $parsed_xml =& new XML($file_name);
	    $parsed_xml = Set::reverse($parsed_xml);
		 // see the returned array
	    return $parsed_xml;
	}
	function saveRow($dataArray,$modelInData,$cleanArray=false,$type="new",$id=""){
		if(in_array($modelInData,$this->configs->info))
			$modelToSave = $this->configs->info[$modelInData];
		else
			$modelToSave = $modelInData;
		$this->$modelToSave = & new $modelToSave;
		if($cleanArray==true)
			$dataArray[$modelToSave] = $this->validCleanVar($dataArray[$modelInData],"return");
	    	else
	    		$dataArray[$modelToSave] = $dataArray[$modelInData];
	    	if(isset($_FILES) and isset($this->configs->src[$modelToSave]) and $modelToSave!="Page"){
			if(isset($this->configs->srcKey[$modelToSave])){
				foreach ($this->configs->srcKey[$modelToSave] as $srkey=>$srvalue) {
					$srcKey=$srvalue;
					if(!empty($_FILES['data']['name'][$modelInData][$srcKey]))
					{
						$targetPath = "img/".$this->configs->src[$modelToSave]."/";
						$filename = $this->uploadFile($_FILES,$targetPath,$modelInData,$srcKey);
						$filename = str_replace($targetPath,"",$filename);
						//$filename = str_replace(".swf","",$filename);
						$dataArray[$modelToSave][$srcKey] = $filename;
					}
					else{
						if($type=="edit"){
							$data = $this->$modelToSave->findById($id,$srcKey);
							$dataArray[$modelToSave][$srcKey] = $data[$modelToSave][$srcKey];
						}
						else
							$dataArray[$modelToSave][$srcKey] = "";
					}
				}
			}
		}
		if(isset($this->configs->fieldsType[$modelToSave])){
			foreach ($this->configs->fieldsType[$modelToSave] as $fieldKey=>$typeValue):
				$oldKey = $fieldKey;
				$fieldKey = inflector::underscore($fieldKey);
				if(!isset($dataArray[$modelToSave][$fieldKey]))
					continue;
				switch ($typeValue){
					case "password":
						if(empty($dataArray[$modelToSave]['password']) and $type=="edit"){
					    		$pass = $this->$modelToSave->findById($id,"password");
					    		$dataArray[$modelToSave]['password'] = $pass[$modelToSave]['password'];
						}
						else
							$dataArray[$modelToSave][$fieldKey] = md5($dataArray[$modelToSave][$fieldKey]);
						break;
					case "date":
						if(!empty($dataArray[$modelToSave][$fieldKey])){
							$new = explode("-",$dataArray[$modelToSave][$fieldKey]);
							$dataArray[$modelToSave][$oldKey] = $new[2]."-".$new[1]."-".$new[0];
						}
						break;
				}
			endforeach;
		}
		if($type=="edit")
			$this->$modelToSave->id = $id;
		if($modelToSave=="Page"){
			$topPages = array("catalogitem","mainarticle");
			if(in_array($dataArray[$modelToSave]['type'],$topPages))
				$dataArray[$modelToSave]['top'] = "false";
			else
				$dataArray[$modelToSave]['top'] = "true";
		}
		$this->$modelToSave->save($dataArray[$modelToSave]);
		if($type=="edit")
			return true;
		else
			return $this->$modelToSave->getLastInsertID();
	}
	public function saveField($modelName,$id,$fieldName){
		$str=iconv("UTF-8","Windows-1255",$_POST['value']);
		$this->$modelName->id=$id;
		$this->$modelName->saveField($fieldName,$str);
		header("Content-Type: text/html; charset=windows-1255"); 
		echo $str;
		die();
	}
	protected function loadSettings(){
		$this->controller->set("fileSrc",$this->configs->src);
		$this->controller->set("fileSrcKey",$this->configs->srcKey);
	}
	function uploadFile($file,$targetPath,$model,$name){
		$file_name_explode=explode(".",basename($file['data']['name'][$model][$name]));
		$newFileName=$file_name_explode[sizeof($file_name_explode)-1];
		$target_path = $targetPath .time().rand().".".$newFileName; 
		if(move_uploaded_file($file['data']['tmp_name'][$model][$name], $target_path)) {
			
		}
		else{
		    return "Error";
		}
		return $target_path;
   	}
   	public function deleteRow($model,$id){
   		$this->$model = & new $model;
   		$this->$model->delete($id);
	}
	protected function inArray($searchIn,$searchKey){
		foreach ($searchIn as $key=>$value):
			if($key==$searchKey)
				return true;
		endforeach;
		return false;
	}
	public function validCleanVar($var,$type="check"){
		uses('sanitize');
		$mrClean = new Sanitize();
		$newArray=array();
		if(is_array($var)){
			foreach ($var as $key=>$checkVar):
				if(!is_array($checkVar)){
					$newArray[$key]=$mrClean->sql($checkVar);
					if($newArray[$key]==$checkVar)
						$flag=true;
					else 
						$flag=false;
				}
			endforeach;
		}
		else{
			$newArray=$mrClean->sql($var);
			if($newArray==$var)
				$flag=true;
			else
				$flag=false;
		}
		if($type=="check")
			return $flag;
		else 
			return $newArray;
	}
}
?>
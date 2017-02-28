<?php
class AdminAppController extends AppController {
	var $name = 'Admin';
	var $helpers = array('Html','javascript','Form','Admin.Quatro');
	var $uses = array("Admin","Page");
	var $layout = 'admin';
	var $components = array('Mail','Datamanage','Session');
	function beforeFilter(){
		//require 'vendors/jsonwrapper/jsonwrapper.php';
		$this->currentUrl = $_SERVER['REQUEST_URI'];
		$this->set("currentUrl",$this->currentUrl);
		$this->configs = loadAdminControllerVars();
		$this->Datamanage->configs = loadDataManageVars();
		$this->admin = $this->Session->read('Admin');
		$this->set("userDetails",$this->admin);
		$this->loadXmls();
		$this->set("site_direction",$this->configs->config_direction);
		App::import('Vendor', $this->configs->config_langsFile);
		$this->toolTipTexts = array("added"=>_LANG_TOOLTIPTEXT_ADDED,"edited"=>_LANG_TOOLTIPTEXT_EDITED,"deleted"=>_LANG_TOOLTIPTEXT_DELETED,"notfound"=>_LANG_TOOLTIPTEXT_NOTFOUND,"err_permission"=>_LANG_TOOLTIPTEXT_PERMISSION,"require"=>_LANG_TOOLTIPTEXT_REQUIRE,"error"=>_LANG_TOOLTIPTEXT_ERROR,"passwordsmismatch"=>_LANG_TOOLTIPTEXT_PASSWORDS_MISMATCH);
		$this->set("toolTipTexts",json_encode($this->toolTipTexts));
		
		if($this->Session->check('currentLang'))
			$this->currentLang = $this->Session->read('currentLang');
		else
			$this->currentLang = "1";
		$this->set("currentLang",$this->currentLang);
		$this->getTooltip();
		$this->deleteTooltip();	
	}
	/**
	 * will set the list icons to the list page
	 * add,edit,delete icons
	 *
	 */
	function setListIcons(){
		if($this->admin['type']=="superadmin"){
			$this->array_not_delete_icon = $this->configs->config_adminType_superadmin_notDeleteIcon;
			$this->array_not_edit_icon = $this->configs->config_adminType_superadmin_notEditIcon;
			$this->array_not_add_icon = $this->configs->config_adminType_superadmin_notAddIcon;
		}
		else{
			$this->array_not_delete_icon = $this->configs->config_adminType_admin_notDeleteIcon;
			$this->array_not_edit_icon = $this->configs->config_adminType_admin_notEditIcon;
			$this->array_not_add_icon = $this->configs->config_adminType_admin_notAddIcon;
		}
		$this->set("array_edit_icon_click",$this->configs->config_array_edit_icon_click);
		$this->set("array_not_delete_icon",$this->array_not_delete_icon);
		$this->set("array_not_edit_icon",$this->array_not_edit_icon);
		$this->set("array_not_add_icon",$this->array_not_add_icon);
	}
	/**
	 * login function
	 * will check if the data is sanitize and the user is in db.
	 * if the data is not sanitize will add it to error log.
	 *
	 */
	function login(){
		if ($this->Session->check('Admin'))
		{
			$this->redirect('/admin');
			die();
		}
		$this->layout="login";
		if (!empty($this->data))
		{
			if($this->validCleanVar($this->data['User'])){
				$typesToCheck=array("Admin");
				foreach ($typesToCheck as $modelToCheck):
					if($session=$this->$modelToCheck->authenticate($modelToCheck,$this->data['User']['username'],$this->data['User']['password'])){
						$this->Session->write($modelToCheck, $session);
						$flag="true";
					}
				endforeach;
				if(!isset($flag) or $flag!="true"){
					print("Error");
	                die();
				}
				else{
					echo "Fine";
					die();
				}
			}
			else{
				die("Critical Error");
			}
        }
	}
	/**
	 * logout the user
	 *
	 */
	function logout(){
		$this->checkSession();
		$this->Session->delete('Admin');
		$this->redirect("/admin/login");
	}
	
	function manageActions($model,$type="list",$id=""){
		$this->checkSession();
		$navs = array();
		if(isset($navs[$model]))
			$this->loadNavs($navs[$model]);
		switch ($type){
			case "list":
				if(isset($_GET['page']) and is_numeric($_GET['page']))
					$page = $_GET['page'];
				else
					$page = 1;
				$this->Datamanage->generateList($model,$page);
				if(isset($_GET['orderby']))
					$this->render("../elements/lists","emptyLayout");
				else
					$this->render("list");
				break;
			case "edit":
				$this->Datamanage->generateForm($model,"edit",$id);
				$this->render("data_new");
				break;
			case "new":
				$this->Datamanage->generateForm($model);
				$this->render("data_new");
				break;
				
		}
	}
	function loadXmls(){
		$headercats = $this->Datamanage->loadFieldsFromXml(ADMIN_CONFIGS."adminxmls/headcats.xml");
		$this->set("headercats",$headercats['Items']['Item']);
		
		/*$aditionalmenu = $this->Datamanage->loadFieldsFromXml(ADMIN_CONFIGS."adminxmls/navs.xml");
		$this->set("aditionalmenu",$aditionalmenu['Items']['Content']['Item']);*/
	}
	/**
	 * check seesion of the user to check if he is online or not he will be redirect to login
	 *
	 */
	function checkSession(){
		$adminSession = $this->Session->read('Admin');
		if (empty($adminSession))
		{
			// Force the user to login
			$this->redirect('/admin/login');
			die();
		}
    }
	/**
	 * get the order type and field by ajax and return the list of the current model used...
	 *
	 * @param string $model
	 * @param int $_GET['perpage'] not require
	 * @param string $_GET['orderby'] not require ,order by field
	 * @param string $_GET['ordertype'] not require ,value can be : asc or desc
	*/
	function getAjaxOrder($model){
		if(!in_array($model,$this->uses)){
			echo "Error Model";
			die();
		}
		$this->setListIcons();
		if(isset($_GET['perpage']) and is_numeric($_GET['perpage']) and $_GET['perpage']>0){
			$this->Datamanage->items_per_page = $_GET['perpage'];
		}
		if(isset($_GET['orderby']) and !empty($_GET['orderby']) and $this->$model->hasField($_GET['orderby'])){
			$orderBy = $_GET['orderby'];
			if(isset($_GET['ordertype']) and !empty($_GET['ordertype']) and ($_GET['ordertype']=="asc" or $_GET['ordertype']=="desc")){	
				$orderType = $_GET['ordertype'];
			}
			else
				$orderType = "asc";
			$this->Datamanage->orderBy = $orderBy." ".$orderType;
		}
		$this->Datamanage->generateList($model,"");
		$this->render("../elements/lists","emptyLayout");
	}
	function setPositionAjax2($model,$id=""){
		if(isset($this->data)){
			$data=explode("&",$this->data);
			$str = "listtablelistbody";
			foreach ($data as $key=>$value):
				$idOfNewPosition=str_replace($str."[]=","",$value);
				if(!empty($idOfNewPosition) and is_numeric($idOfNewPosition)){
					$this->$model->id=$idOfNewPosition;
					$this->$model->saveField("position",$key+1);
				}
			endforeach;
		}
		die();
	}
	function setPositionAjax($model,$id=""){
		if(isset($this->data)){
			$data = (array) json_decode($this->data);
			$str = "row_";
			foreach ($data as $key=>$value):
				$idOfNewPosition = str_replace($str,"",$key);
				if(!empty($idOfNewPosition) and is_numeric($idOfNewPosition)){
					$this->$model->id = $idOfNewPosition;
					$this->$model->saveField("position",$value);
				}
			endforeach;
		}
		die();
	}
	function validateData($data,$model,$editId=false){
		$cleanData = $this->validCleanVar($data,"return");
		$RequireFields = $this->Datamanage->loadFieldsFromXml(ADMIN_CONFIGS."adminxmls/models/$model.xml");
		if(!isset($RequireFields['Items']['Require']['Fields'])){
			return "Fine";
			die();
		}
		$requireArray = $RequireFields['Items']['Require']['Fields'];
		if(is_numeric($editId)){
			if(isset($requireArray['password']))
				unset($requireArray['password']);
		}
		if(!$this->checkIfNotEmpty($cleanData,array_keys($requireArray))){
			return "Require";
		}
		foreach ($cleanData as $key=>$value):
			switch ($key){
				case "email":
					if(!empty($value) and !$this->Mail->valid_email($value)){
						return "Email Format";
					}
					if(is_numeric($editId)){
						if($this->$model->hasAny("email='$value' and id!='$editId'")){
							return "Email Exist";
						}
					}
					else{
						if($this->$model->hasAny("email='$value'")){
							return "Email Exist";
						}
					}
					break;
				case "username":
					if(is_numeric($editId)){
						if($this->$model->hasAny("username='$value' and id!='$editId'")){
							return "Username Exist";
						}
					}
					else{
						if($this->$model->hasAny("username='$value'")){
							return "Username Exist";
						}
					}
					break;
				case "password":
					if($cleanData['password']!=$cleanData['passwordconfirm']){
						return "Passwords Mismatch";
					}
					break;
				default:
					if(isset($RequireFields['items']['validate']) and isset($RequireFields['items']['validate'][$key])){
						switch ($RequireFields['items']['validate'][$key]['type']){
							case "numeric":
								if(!is_numeric($value))
								{
									return $RequireFields['Items']['validate'][$key]['error'];
								}
								break;
							case "date":
								$new=explode("-",$value);
	    						if(!isset($new[1]) or !isset($new[0]) or !isset($new[2]) or !checkdate($new[1],$new[0],$new[2])){
	    							return $RequireFields['Items']['validate'][$key]['error'];
	    						}
								break;
						}
					}
					break;
			}
		endforeach;
		return "Fine";
   	}
   	function saveTooltip($tooltipType){
		$this->checkSession();
		switch ($tooltipType){
			case "added":
				$text = _LANG_TOOLTIPTEXT_ADDED;
				$type = "Ok";
				break;
			case "edited":
				$text = _LANG_TOOLTIPTEXT_EDITED;
				$type = "Ok";
				break;
			case "deleted":
				$text = _LANG_TOOLTIPTEXT_DELETED;
				$type = "Ok";
				break;
			case "notfound":
				$text = _LANG_TOOLTIPTEXT_NOTFOUND;
				$type = "Error";
				break;
			case "err_permission":
				$text = _LANG_TOOLTIPTEXT_PERMISSION;
				$type = "Error";
				break;
			case "require":
				$text = _LANG_TOOLTIPTEXT_REQUIRE;
				$type = "Error";
				break;
			case "error":
				$text = _LANG_TOOLTIPTEXT_ERROR;
				$type = "Error";
				break;
			default:
				break;
		}
		if(isset($text)){
			$this->Session->write("ToolTip", $text);
			$this->Session->write("ToolTipType", $type);
		}
	}
	function getTooltip(){
		$text = $this->Session->read("ToolTip");
		$type = $this->Session->read("ToolTipType");
		$this->set("tooltiptext",$text);
		$this->set("tooltiptype",$type);
	}
	function deleteTooltip(){
		$this->Session->delete("ToolTip");
	}
	function checkPermissions($type,$model,$id){
		if($this->admin['type']=="superadmin")
			return true;
		switch ($type){
			case "new":
				if(in_array($model,$this->array_not_add_icon))
					$flag = "error";
				break;
			case "edit":
				if(in_array($model,$this->array_not_edit_icon))
					$flag = "error";
				break;
			case "delete":
				if(in_array($model,$this->array_not_delete_icon))
					$flag = "error";
				break;
		}
		if(isset($flag) and $flag=="error")
		{
			$this->saveTooltip("err_permission");
			if($type=="list")
				$this->redirect("/admin/");
			else
				$this->redirect("/admin/itemManagement/$model/");
			die();
		}
	}
	function changelang(){
		$this->checkSession();
		if(isset($this->data['lang']) and is_numeric($this->data['lang']['change'])){
			$this->Session->delete('currentLang');
			$this->Session->write("currentLang", $this->data['lang']['change']);
			$this->redirect("/admin/");
			die();
		}
		$langs = $this->Language->getlist(null, null, null, 'Language.id', 'Language.name');
		$this->set("allLangs",$langs);
	}
	function deleteFileUrl($model,$key,$id){
		$this->checkSession();
		if(is_numeric($id) and $this->$model->hasAny("id=$id")){
			$arrayOfImages = array();
			if(in_array($key,$arrayOfImages)){
				if($find = $this->Pages_param->find("page_id=$id and Pages_param.key='$key'")){
					$this->Pages_param->delete($find['Pages_param']['id']);
				}
				die();
			}
			$this->$model->id = $id;
			$this->$model->saveField($key,"");
		}
		die();
	}
	function editDetails(){
		$this->set("editData","true");
		$this->set("editDataId","1");
		$this->set("AjaxUrl","/admin");
		$this->set("formAction","/admin/itemManagement/Admin/editstore/1");
		$this->manageActions("Admin","edit","1");
	}
	function loadNavs($model){
		$this->checkSession();
		$aditionalmenu = $this->Datamanage->loadFieldsFromXml(ADMIN_CONFIGS."adminxmls/navs.xml");
		$aditionalmenuItem = $aditionalmenu['Items'][inflector::camelize($model)]['Item'];
		if(!isset($aditionalmenuItem[0])){
			$temp = $aditionalmenuItem;
			unset($aditionalmenuItem);
			$aditionalmenuItem[0] = $temp;
		}
		$this->set("aditionalmenu",$aditionalmenuItem);
		$this->set("navModel",$model);
		/*$navs = $this->Domxml->parseFile("adminxmls/navs.xml");
		$navs = $navs['items'][$model]['item'];
		$this->set("rightNavs",$navs);
		if(!isset($navs[0])){
			$breadcrumbslist[$navs['link']]=$navs['name'];
		}
		else{
			foreach ($navs as $nav):
				$breadcrumbslist[$nav['link']]=$nav['name'];
			endforeach;
		}*/
		//$this->set("breadcrumbslist",$breadcrumbslist);
		//$this->set("navModel",$model);
	}
	function setSearch($model=""){
		if(isset($_GET['searchfields'])){
			$text = $_GET['searchvalue'];
			$this->set("searchVar","searchfields=".$_GET['searchfields']."&searchvalue=$text");
			if(empty($_GET['searchfields'])){
				$arrayOfFields = $this->Datamanage->loadFieldsFromXml($this->Datamanage->configs->xml_folder."/".$this->Datamanage->configs->models_xml_folder."/".$model.".xml");
				if(!isset($arrayOfFields['Items']['Search']['Fields']))
					return "";
				$cond = "";
				$fields = array_keys($arrayOfFields['Items']['Search']['Fields']);
				foreach ($fields as $field):
					if(!empty($cond))
						$cond .= " or ";
					$cond .= "$model.$field like '%$text%'";
				endforeach;
			}
			else{
				$field = $_GET['searchfields'];
				$cond = "$model.$field like '%$text%'";
			}
			return "(".$cond.")";
		}
	}
}
?>
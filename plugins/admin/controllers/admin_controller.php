<?php
class AdminController extends AdminAppController{
	var $name = 'Admin';
	var $helpers = array('Html','javascript','Form','Admin.Quatro');
	var $uses = array("Admin","Page","Pages_param","Article","Menu","News","Item","Question","Event","Answer","Staff","Gallery","Survey","Box","Portalitem","Emailslayout","Mainitem","Drug","Surveyanswer","Pagegallery");
	var $layout = 'admin';
	var $components = array('Datamanage','Graph',"Image");
	function beforeFilter(){
		parent::beforeFilter();
	}
	function index(){
		$this->checkSession();
	}
	function itemManagement($model="",$type="list",$id=""){
		$this->checkSession();
		if(!in_array($model,$this->uses)){
			$this->saveTooltip("notfound");
			$this->redirect("/admin/");
			die();
		}
		$this->setListIcons();
		switch($type){
			case "list":
				$this->Datamanage->orderBy = "dateAdd asc";
				$this->Datamanage->cond = "";
				$this->set("page","/admin/itemManagement/$model");
				if(isset($this->configs->config_handlePositionModels[$model])){
					$this->Datamanage->orderBy = "position asc";
					$this->set("handle","true");
					if(!empty($this->configs->config_handlePositionModels[$model])){
						$this->Datamanage->orderBy = $this->configs->config_handlePositionModels[$model]." asc,position asc";
						$this->set("fieldForPosition",$this->configs->config_handlePositionModels[$model]);
					}
				}
				if(in_array($model,$this->configs->config_modelFieldsAjaxOrder)){
					$this->set("ajaxSort","true");
				}
				if(isset($_GET['perpage'])){
					if(is_numeric($_GET['perpage']) and $_GET['perpage']>0)
						$this->Datamanage->configs->items_per_page = $_GET['perpage'];
					if($_GET['perpage']=="all")
						$this->Datamanage->configs->items_per_page = "";
					$this->set("perpage",$_GET['perpage']);
				}
				$this->set("perPageFilter",isset($_GET['perpage']) ? $_GET['perpage'] : $this->Datamanage->configs->items_per_page);
				if(isset($_GET['orderby']) and !empty($_GET['orderby']) and $this->$model->hasField($_GET['orderby'])){
					$orderBy = "";
					if($model=="Category")
						$orderBy = "type asc,";
					$orderBy .= $_GET['orderby'];
					if(isset($_GET['ordertype']) and !empty($_GET['ordertype']) and ($_GET['ordertype']=="asc" or $_GET['ordertype']=="desc")){	
						$orderType = $_GET['ordertype'];
					}
					else
						$orderType = "asc";
					$this->Datamanage->orderBy = $orderBy." ".$orderType;
				}
				if(isset($_GET['searchfields'])){
					$this->Datamanage->cond = $this->setSearch($model);
					$this->set("search","true");
					$this->set("page","/admin/itemManagement/$model?searchfields=".$_GET['searchfields']."&searchvalue=".$_GET['searchvalue']);
				}
				if($model=="Page"){
					if(!empty($this->Datamanage->cond))
						$this->Datamanage->cond .= " and ";
					$this->Datamanage->cond .= "top='true'";
				}
				switch($model){
					case "Article":
						$this->Datamanage->cond = "parent_id='0' or parent_id is null";
						break;
					case "Drug":
						$this->Datamanage->cond = "parent='0' or parent is null";
						if(isset($_GET['parent']) and !empty($_GET['parent'])){
							$parent = $_GET['parent'];
							$this->Datamanage->cond = "parent = '$parent'";
							$this->set("pageAddNew","/admin/itemManagement/Drug/new?parent=$parent");
							$hardTopTitle = "רשימת תרופות תחת ".$this->Drug->getValue("Drug",$_GET['parent'],"name");
							$this->set("hardTopTitle",$hardTopTitle);
						}
						break;
					case "Menu":
						$this->Datamanage->cond = "(type = 'header' or type = 'footer') and (parent_id='' or parent_id is null)";
						if(isset($_GET['type']) and !empty($_GET['type'])){
							$type = $_GET['type'];
							$this->Datamanage->cond = "type = '$type'";
							$this->set("pageAddNew","/admin/itemManagement/Menu/new?type=$type");
							if(isset($_GET['page_id']) and !empty($_GET['page_id'])){
								$page_id = $_GET['page_id'];
								$this->Datamanage->cond .= " and page_connected_id = '$page_id' and parent_id IS NULL";
								$this->set("pageAddNew","/admin/itemManagement/Menu/new?type=$type&page_connected_id=$page_id");
								$hardTopTitle = "רשימת פריטים תחת ".$this->Page->getValue("Page",$page_id,"pname");
								$this->set("hardTopTitle",$hardTopTitle);
							}
						}
						if(isset($_GET['parent_id']) and !empty($_GET['parent_id'])){
							$parent_id = $_GET['parent_id'];
							$this->Datamanage->cond = "parent_id = '$parent_id'";
							$typeOfMenu = $this->Menu->getValue("Menu",$parent_id,"type");
							if($typeOfMenu=="footer")
								$this->set("pageAddNew","/admin/itemManagement/Menu/new?parent_id=$parent_id");
							else
								$this->set("pageAddNew","/admin/itemManagement/Article/new?parent_id=$parent_id");
							$hardTopTitle = "רשימת פריטים תחת ".$this->Menu->getValue("Menu",$_GET['parent_id'],"name");
							$this->set("hardTopTitle",$hardTopTitle);
						}
						if(empty($this->Datamanage->orderBy) or $this->Datamanage->orderBy=="dateAdd asc")
							$this->Datamanage->orderBy = "type asc,position asc";
						break;
					case "Page":
						if(isset($_GET['type']) and !empty($_GET['type'])){
							$type = $_GET['type'];
							$this->Datamanage->cond = "type = '$type'";
							$this->set("pageAddNew","/admin/itemManagement/Page/new?type=$type");
							if(empty($this->Datamanage->orderBy) or $this->Datamanage->orderBy=="dateAdd asc")
								$this->Datamanage->orderBy = "type asc,dateAdd asc";
						}
						break;
					case "Portalitem":
						if(isset($_GET['page_id']) and !empty($_GET['page_id'])){
							$page_id = $_GET['page_id'];
							$this->Datamanage->cond = "page_id = '$page_id'";
							$this->set("pageAddNew","/admin/itemManagement/Portalitem/new?page_id=$page_id");
						}
						break;
					case "Mainitem":
						if(isset($_GET['page_id']) and !empty($_GET['page_id']) and isset($_GET['type']) and !empty($_GET['type'])){
							$page_id = $_GET['page_id'];
							$this->Datamanage->cond = "page_id = '$page_id' and type='".$_GET['type']."'";
							$this->set("pageAddNew","/admin/itemManagement/Mainitem/new?page_id=$page_id&type=".$_GET['type']);
						}
						break;
					case "Galleryimage":
						if(isset($_GET['page_id']) and !empty($_GET['page_id'])){
							$page_id = $_GET['page_id'];
							$this->Datamanage->cond = "page_id = '$page_id'";
							$this->set("pageAddNew","/admin/itemManagement/Galleryimage/new?page_id=$page_id");
						}
						break;
					case "Answer":
						if(isset($_GET['question_id']) and !empty($_GET['question_id'])){
							$question_id = $_GET['question_id'];
							$this->Datamanage->cond = "question_id = '$question_id'";
							$this->set("pageAddNew","/admin/itemManagement/Answer/new?question_id=$question_id");
						}
						break;
					case "Box":
						if(isset($_GET['type']) and !empty($_GET['type'])){
							$type = $_GET['type'];
							$this->Datamanage->cond = "type = '$type'";
							$this->set("pageAddNew","/admin/itemManagement/Box/new?type=$type");
							if(isset($_GET['page_id']) and !empty($_GET['page_id'])){
								$page_id = $_GET['page_id'];
								$this->Datamanage->cond .= " and type_id = '$page_id'";
								$this->set("pageAddNew","/admin/itemManagement/Box/new?type=$type&page_id=$page_id");
								$hardTopTitle = "רשימת אייטמים תחת ".$this->Page->getValue("Page",$page_id,"pname");
								$this->set("hardTopTitle",$hardTopTitle);
							}
						}
						break;
					case "Gallery":
						if(isset($_GET['type']) and !empty($_GET['type'])){
							$type = $_GET['type'];
							$this->Datamanage->cond = "type = '$type'";
							$this->set("pageAddNew","/admin/itemManagement/Gallery/new?type=$type");
							if(isset($_GET['page_id']) and !empty($_GET['page_id'])){
								$page_id = $_GET['page_id'];
								$this->Datamanage->cond .= " and type_id = '$page_id'";
								$this->set("pageAddNew","/admin/itemManagement/Gallery/new?type=$type&page_id=$page_id");
								$hardTopTitle = "רשימת תמונות תחת ".$this->Page->getValue("Page",$page_id,"pname");
								$this->set("hardTopTitle",$hardTopTitle);
							}
						}
						break;
					case "Question":
						if(isset($_GET['parent']) and !empty($_GET['parent'])){
							$page_id = $_GET['parent'];
							$this->Datamanage->cond = "page_id = '$page_id'";
							$this->set("pageAddNew","/admin/itemManagement/Question/new?page_id=$page_id");
							$hardTopTitle = "רשימת שאלות תחת ".$this->Page->getValue("Page",$page_id,"pname");
							$this->set("hardTopTitle",$hardTopTitle);
						}
						break;
					case "Pagegallery":
						if(isset($_GET['pageconnectedid']) and !empty($_GET['pageconnectedid'])){
							$page_id = $_GET['pageconnectedid'];
							$this->Datamanage->cond = "pageconnectedid = '$page_id'";
							$this->set("pageAddNew","/admin/itemManagement/Pagegallery/new?pageconnectedid=$page_id");
							$hardTopTitle = "רשימת תמונות תחת ".$this->Page->getValue("Page",$page_id,"pname");
							$this->set("hardTopTitle",$hardTopTitle);
						}
						if(isset($_GET['parent']) and !empty($_GET['parent'])){
							$parent = $_GET['parent'];
							$this->Datamanage->cond = "parent = '$parent'";
							$this->set("pageAddNew","/admin/itemManagement/Pagegallery/new?parent=$parent");
							$hardTopTitle = "רשימת תמונות תחת ".$this->Pagegallery->getValue("Pagegallery",$parent,"name");
							$this->set("hardTopTitle",$hardTopTitle);
						}
						break;
				}
				$this->manageActions($model,"list");
				break;
			case "new":
				$this->checkPermissions("new",$model,$id);
				if(!in_array($model,$this->configs->config_notAjaxForms))
					$this->set("AjaxUrl","/admin/itemManagement/$model/");
				$this->set("formAction","/admin/itemManagement/$model/newstore");
				$data = $this->Session->read("data");
				$this->data[$model] = $data;
				switch ($model){
					case "Menu":
						if(isset($_GET['page_connected_id'])){
							$hardTopTitle = "הוספת פריטים תחת ".$this->Page->getValue("Page",$_GET['page_connected_id'],"pname");
							$this->set("hardTopTitle",$hardTopTitle);
						}
						$ajaxUrl = "/admin/itemManagement/$model/?";
						
						if(!empty($_GET['type'])){
							$ajaxUrl .= "&type=".$_GET['type'];
						}
						if(!empty($_GET['page_connected_id'])){
							$ajaxUrl .= "&page_id=".$_GET['page_connected_id'];
						}
						
						$this->set("AjaxUrl",$ajaxUrl);
						
						break;
					case "Portalitem":
						if(isset($_GET['page_id']) and !empty($_GET['page_id'])){
							$page_id = $_GET['page_id'];
							$articlesConnected = $this->Page->find("list",array("conditions"=>"type='article' and parent=$page_id","fields"=>"id,pname"));
							$this->set("PageConnectedid",$articlesConnected);
						}
						break;
					case "Galleryimage":
						if(isset($_GET['page_id']) and !empty($_GET['page_id'])){
							$this->data['Galleryimage']['page_id'] = $_GET['page_id'];
						}
						break;
					case "Box":
						if(isset($_GET['type']) and !empty($_GET['type'])){
							$this->data['Box']['type'] = $_GET['type'];
						}
						if(isset($_GET['page_id']) and !empty($_GET['page_id'])){
							$this->data['Box']['type_id'] = $_GET['page_id'];
						}
						break;
					case "Gallery":
						if(isset($_GET['type']) and !empty($_GET['type'])){
							$this->data['Gallery']['type'] = $_GET['type'];
						}
						if(isset($_GET['page_id']) and !empty($_GET['page_id'])){
							$this->data['Gallery']['type_id'] = $_GET['page_id'];
						}
						break;
					case "Answer":
						if(isset($_GET['question_id']) and !empty($_GET['question_id'])){
							$this->data['Answer']['question_id'] = $_GET['question_id'];
							$this->set("AjaxUrl","/admin/itemManagement/$model?question_id=".$_GET['question_id']);
						}
						break;
					case "Article":
						$items = $this->Item->find("list",array("fields"=>array('id','name')));
						$this->set("addItems",$items);
						if(isset($_GET['parent_id']) and !empty($_GET['parent_id']) and is_numeric($_GET['parent_id'])){
							$page_id = $this->Menu->getValue("Menu",$_GET['parent_id'],"page_connected_id");
							$link = $this->Page->getValue("Page",$page_id,"link");
							$this->set("startLink",$link."/");
							$this->data['Article']['startlink'] = $link."/";
						}
						break;
					case "Event":
						if($eventPage = $this->Page->find("type='events'","link")){
							$this->data['Event']['link'] = $eventPage['Page']['link'];
						}
						break;
					case "Question":
						if(!isset($_GET['page_id'])){
							$this->redirect("/admin");
							die();
						}
						$this->set("AjaxUrl","/admin/itemManagement/$model?parent=".$_GET['page_id']);
						break;
					case "Page":
						if(isset($_GET['type']) and !empty($_GET['type'])){
							//$this->Datamanage->PageType = $_GET['type'];
							$this->data['Page']['type'] = $_GET['type'];
						}						
						break;
				}
				$this->Session->delete('data');
				$this->manageActions($model,"new");
			break;
			case "edit":
				if($model=="Page" and isset($_GET['Page_Type']) and !empty($_GET['Page_Type'])){
					$page_type = $_GET['Page_Type'];
					if($page = $this->Page->find("type='$page_type'","id"))
						$id = $page['Page']['id'];
				}
				$this->checkPermissions("edit",$model,$id);
				$this->set("editData","true");
				$this->set("editDataId",$id);
				if(!$this->$model->hasAny("id=$id")){
					$this->saveTooltip("notfound");
					if(isset($page_type))
						$this->redirect("/admin/itemManagement/$model/list/?Page_Type=".$page_type);
					else
						$this->redirect("/admin/itemManagement/$model/");
					die();
				}
				if(!in_array($model,$this->configs->config_notAjaxForms))
					$this->set("AjaxUrl","/admin/itemManagement/$model/");
				switch ($model){
					case "Article":
						$items = $this->Item->find("list",array("fields"=>array('id','name')));
						$this->set("addItems",$items);
						break;
					case "Portalitem":
						$page_id = $this->Portalitem->getValue("Portalitem",$id,"page_id");
						$articlesConnected = $this->Page->find("list",array("conditions"=>"type='article' and parent=$page_id","fields"=>"id,pname"));
						$this->set("PageConnectedid",$articlesConnected);
						break;
					case "Menu":
						$menu = $this->Menu->find("id='$id'");
						$this->Datamanage->generateForm($model,"edit",$id);
						if($this->data['Menu']['page_id']!=0 and !empty($this->data['Menu']['page_id'])){
							unset($this->data['Menu']['link']);
						}
						$ajaxUrl = "/admin/itemManagement/$model/?";
						
						if(!empty($menu['Menu']['type'])){
							$ajaxUrl .= "&type=".$menu['Menu']['type'];
						}
						if(!empty($menu['Menu']['page_connected_id'])){
							$ajaxUrl .= "&page_id=".$menu['Menu']['page_connected_id'];
						}
						
						$this->set("AjaxUrl",$ajaxUrl);
						$this->set("formAction","/admin/itemManagement/$model/editstore/$id");
						$type = (isset($_GET['type']) and !empty($_GET['type'])) ? $_GET['type'] : "header";
						$this->set("menu_type",$type);
						echo $this->render("data_new");
						die();
						break;
					case "Page":
						$this->set("page_type","index");
						$this->Datamanage->PageType = "index";
						if($found = $this->Page->findById($id,"type")){
							$this->Datamanage->PageType = $found['Page']['type'];
							$this->set("page_type",$found['Page']['type']);
						}
						break;
					case "Question":
						$page_id = $this->Question->getValue("Question",$id,"page_id");
						$this->set("AjaxUrl","/admin/itemManagement/$model?parent=".$page_id);
						break;
	    		}
				$this->set("formAction","/admin/itemManagement/$model/editstore/$id");
				$this->manageActions($model,"edit",$id);
				break;
			case "newstore":
				$this->checkPermissions("new",$model,$id);
				$this->data[$model]['langId'] = $this->currentLang;
				$answer = $this->validateData($this->data[$model],$model,$id);
				if($answer=="Fine"){
					switch ($model) {
						case "Article":
							if($this->data['Article']['month']<10)
								$this->data['Article']['month'] = "0".$this->data['Article']['month'];
							$this->data['Article']['date_of_article'] = $this->data['Article']['year']['year']."-".$this->data['Article']['month']."-01";
							if(isset($this->data[$model]['startlink']))
								$this->data[$model]['link'] = $this->data[$model]['startlink'].$this->data[$model]['link'];
							$menuParent = $this->Menu->find("id='".$this->data['Article']['parent_id']."'");
							$newPageArray['link'] = $this->data[$model]['link'];
							$newPageArray['meta_title'] = $this->data[$model]['meta_title'];
							$newPageArray['meta_description'] = $this->data[$model]['meta_description'];
							$newPageArray['meta_keywords'] = $this->data[$model]['meta_keywords'];
							$newPageArray['type'] = "article";
							$newPageArray['pname'] = $this->data[$model]['name'];
							$newPageArray['content'] = $this->data[$model]['content'];
							$newPageArray['lang'] = $this->data[$model]['lang'];
							if(isset($menuParent['Menu']['page_connected_id']))
								$newPageArray['parent'] = $menuParent['Menu']['page_connected_id'];
							else{
								$news = $this->Page->find("type='news'",array("fields"=>"id"));
								$newPageArray['parent'] = $news['Page']['id'];
							}
							$this->Page->save($newPageArray);
							$this->data[$model]['page_id'] = $this->Page->getLastInsertID();
							if(!isset($this->data['Article']['parent_id']) or empty($this->data['Article']['parent_id']))
								$this->data['Article']['parent_id'] = 0;
							$lastId = $this->Datamanage->saveRow($this->data,$model);
							if(isset($menuParent['Menu']['page_connected_id'])){
								$newMenu['page_connected_id'] = $menuParent['Menu']['page_connected_id'];
								$newMenu['type'] = "category";
								$newMenu['name'] = $this->data['Article']['name'];
								$newMenu['parent_id'] = $this->data['Article']['parent_id'];
								$newMenu['page_id'] = $this->data[$model]['page_id'];
								$newMenu['article_id'] = $lastId;
								$newMenu['link'] = "/".$this->data['Article']['link'];
								$this->Menu->save($newMenu);
							}
							$this->saveTooltip("added");
							if(isset($this->data[$model]['parent_id']) and !empty($this->data[$model]['parent_id']) and $this->data[$model]['parent_id']>0)
								$this->redirect("itemManagement/Menu/list?parent_id=".$this->data[$model]['parent_id']);
							else
								$this->redirect("itemManagement/Article");
							die();
							break;
						case "Box":
							$lastId = $this->Datamanage->saveRow($this->data,$model);
							$this->saveTooltip("added");
							$this->redirect("itemManagement/Box/list?type=".$this->data[$model]['type']."&page_id=".$this->data[$model]['type_id']);
							die();
							break;
						case "Drug":
							$lastId = $this->Datamanage->saveRow($this->data,$model);
							$this->saveTooltip("added");
							if(isset($this->data[$model]['parent']) and !empty($this->data[$model]['parent']) and $this->data[$model]['parent']>0)
								$this->redirect("itemManagement/Drug/list?parent=".$this->data[$model]['parent']);
							else
								$this->redirect("itemManagement/Drug/list");
							die();
							break;
						case "Gallery":
							$lastId = $this->Datamanage->saveRow($this->data,$model);
							$this->saveTooltip("added");
							$this->redirect("itemManagement/Gallery/list?type=".$this->data[$model]['type']."&page_id=".$this->data[$model]['type_id']);
							die();
							break;
						case "Event":
							$newPageArray['link'] = $this->data[$model]['link'];
							$newPageArray['meta_title'] = $this->data[$model]['meta_title'];
							$newPageArray['meta_description'] = $this->data[$model]['meta_description'];
							$newPageArray['meta_keywords'] = $this->data[$model]['meta_keywords'];
							$newPageArray['type'] = "event";
							$newPageArray['pname'] = $this->data[$model]['name'];
							$newPageArray['content'] = $this->data[$model]['text'];
							$this->Page->save($newPageArray);
							$this->data[$model]['page_id'] = $this->Page->getLastInsertID();
							$lastId = $this->Datamanage->saveRow($this->data,$model);
							$this->saveTooltip("added");
							$this->redirect("itemManagement/Event/list");
							die();
							break;
						case "Pagegallery":
							if(isset($this->data[$model]['pageconnectedid'])){
								$newPageArray['link'] = $this->data[$model]['link'];
								$newPageArray['meta_title'] = $this->data[$model]['meta_title'];
								$newPageArray['meta_description'] = $this->data[$model]['meta_description'];
								$newPageArray['meta_keywords'] = $this->data[$model]['meta_keywords'];
								$newPageArray['type'] = "galleryinner";
								$newPageArray['pname'] = $this->data[$model]['name'];
								$newPageArray['content'] = "";
								$this->Page->save($newPageArray);
								$this->data[$model]['page_id'] = $this->Page->getLastInsertID();
							}else
								$this->data[$model]['page_id'] = 0;
							$lastId = $this->Datamanage->saveRow($this->data,$model);
							if(isset($this->data[$model]['parent'])){
								$oldSrc = $this->Pagegallery->getValue("Pagegallery",$lastId,"src");
								$src = "img/".$this->Datamanage->configs->src[$model]."/".$oldSrc;
								$smallSrc = "img/".$this->Datamanage->configs->src[$model]."/thumb/".$oldSrc;
								if(!empty($oldSrc)){
									$this->Image->createthumb($src,$smallSrc,"143","105");
								}
							}
							$this->saveTooltip("added");
							if(isset($this->data[$model]['parent']))
								$this->redirect("itemManagement/Pagegallery/list?parent=".$this->data[$model]['parent']);
							else
								$this->redirect("itemManagement/Pagegallery/list?pageconnectedid=".$this->data[$model]['pageconnectedid']);
							die();
							break;
						case "Portalitem":
							if(!empty($this->data[$model]['page_connectedid']) and empty($this->data[$model]['link'])){
								$link = $this->Page->getValue("Page",$this->data[$model]['page_connectedid'],"link");
								$this->data[$model]['link'] = $link;
							}else{
								$this->data[$model]['page_connectedid'] = "0";
							}
							$lastId = $this->Datamanage->saveRow($this->data,$model);
							$this->saveTooltip("added");
							$this->redirect("itemManagement/Portalitem/list?page_id=".$this->data[$model]['page_id']);
							die();
							break;
						case "Mainitem":
							$lastId = $this->Datamanage->saveRow($this->data,$model);
							$this->saveTooltip("added");
							$this->redirect("itemManagement/Mainitem/list?page_id=".$this->data[$model]['page_id']."&type=".$this->data[$model]['type']);
							die();
							break;
						case "Menu":
							//if(isset($this->data['Menu']['link']) and empty($this->data['Menu']['link'])){
								$pageIdConnected = $this->data['Menu']['page_connected_id'];
								$link = $this->Page->getValue("Page",$pageIdConnected,"link");
								$this->data['Menu']['link'] = "/".$link;
							//}
							if(isset($this->data['Menu']['page_id']) and $this->data['Menu']['page_id']==406){
								$link = $this->Page->getValue("Page",406,"link");
								$this->data['Menu']['link'] = "/".$link;
							}
							if(!isset($this->data['Menu']['position']) or empty($this->data['Menu']['position']))
								$this->data['Menu']['position'] = 0;
							$lastId = $this->Datamanage->saveRow($this->data,$model);
							break;
						default:
	    					if(in_array($model,$this->configs->config_notAjaxForms)){
	    						$lastId = $this->Datamanage->saveRow($this->data,$model);				
	    						$page_type = $this->Page->getValue("Page",$lastId,"type");
								$this->checkPagesParamsForModel("Page",$page_type,$lastId);
	    						$this->saveTooltip("added");
								$this->redirect("itemManagement/$model/list");
								die();
		   					}
		   					if($model=="Page"){
		   						$this->data[$model]['top'] = "true";
		   					}
	    					$this->Datamanage->saveRow($this->data,$model);
	    					break;
		    		}
					$this->saveTooltip("added");
					echo "Added";
				}
				else{
					if(in_array($model,$this->configs->config_notAjaxForms)){
						$this->saveTooltip("require");
						$this->Session->write("data",$this->data[$model]);
						if($model=="Page")
							$this->redirect("itemManagement/$model/new/?Page_Type=".$this->data['Page']['type']);
						else
							$this->redirect("itemManagement/$model/new/");
						die();
					}
					echo $answer;
				}
				die();
				break;
			case "editstore":
				$this->checkPermissions("edit",$model,$id);
				$answer = $this->validateData($this->data[$model],$model,$id);
				if($answer=="Fine"){
					//print_r($this->data);
					//die();
					switch ($model){
						case "Menu":
							//if(isset($this->data['Menu']['link']) and empty($this->data['Menu']['link'])){
								$pageIdConnected = $this->data['Menu']['page_id'];
								$link = $this->Page->getValue("Page",$pageIdConnected,"link");
								$this->data['Menu']['link'] = "/".$link;
							//}
							/*if(isset($this->data['Menu']['page_id']) and $this->data['Menu']['page_id']==406){
								$link = $this->Page->getValue("Page",406,"link");
								$this->data['Menu']['link'] = "/".$link;
							}*/
							$this->Datamanage->saveRow($this->data,$model,false,"edit",$id);
							break;
						case "Article":
							if($this->data['Article']['month']<10)
								$this->data['Article']['month'] = "0".$this->data['Article']['month'];
							$this->data['Article']['date_of_article'] = $this->data['Article']['year']['year']."-".$this->data['Article']['month']."-01";
							$preview = false;
							if(isset($_GET['preview'])){
								$preview = true;
							}
							$page_id = $this->Article->getValue("Article",$id,"page_id");
							$menuParent = $this->Menu->find("page_id='$page_id' and parent_id!=''");
							$newPageArray['id'] = $page_id;
							$newPageArray['link'] = $this->data[$model]['link'];
							$newPageArray['meta_title'] = $this->data[$model]['meta_title'];
							$newPageArray['meta_description'] = $this->data[$model]['meta_description'];
							$newPageArray['meta_keywords'] = $this->data[$model]['meta_keywords'];
							$newPageArray['type'] = "article";
							$newPageArray['pname'] = $this->data[$model]['name'];
							$newPageArray['content'] = $this->data[$model]['content'];
							$newPageArray['lang'] = $this->data[$model]['lang'];
							$this->Page->save($newPageArray);
							$this->Datamanage->saveRow($this->data,$model,false,"edit",$id);
							
							$newMenu['id'] = $menuParent['Menu']['id'];
							$newMenu['type'] = "category";
							$newMenu['name'] = $this->data['Article']['name'];
							$newMenu['link'] = "/".$this->data['Article']['link'];
							$this->Menu->save($newMenu);
							
							$this->saveTooltip("edited");
							if($preview==true){
								echo "Added";
							}
							else
								$this->redirect("itemManagement/Menu/list?parent_id=".$this->data[$model]['parent_id']);
							die();
		    				break;
						case "Event":
							$page_id = $this->Event->getValue("Event",$id,"page_id");
							$newPageArray['id'] = $page_id;
							$newPageArray['link'] = $this->data[$model]['link'];
							$newPageArray['meta_title'] = $this->data[$model]['meta_title'];
							$newPageArray['meta_description'] = $this->data[$model]['meta_description'];
							$newPageArray['meta_keywords'] = $this->data[$model]['meta_keywords'];
							$newPageArray['type'] = "event";
							$newPageArray['pname'] = $this->data[$model]['name'];
							$newPageArray['content'] = $this->data[$model]['text'];
							$this->Page->save($newPageArray);
							$this->Datamanage->saveRow($this->data,$model,false,"edit",$id);
							$this->saveTooltip("edited");
							$this->redirect("itemManagement/Event/list");
							die();
		    				break;
						case "Pagegallery":
							$beforeoldSrc = $this->Pagegallery->getValue("Pagegallery",$id,"src");
							$page_id = $this->Pagegallery->getValue("Pagegallery",$id,"page_id");
							$pageconnectedid = $this->Pagegallery->getValue("Pagegallery",$id,"pageconnectedid");
							$parent = $this->Pagegallery->getValue("Pagegallery",$id,"parent");
							if($page_id>0){
								$newPageArray['id'] = $page_id;
								$newPageArray['link'] = $this->data[$model]['link'];
								$newPageArray['meta_title'] = $this->data[$model]['meta_title'];
								$newPageArray['meta_description'] = $this->data[$model]['meta_description'];
								$newPageArray['meta_keywords'] = $this->data[$model]['meta_keywords'];
								$newPageArray['type'] = "galleryinner";
								$newPageArray['pname'] = $this->data[$model]['name'];
								$newPageArray['content'] = "";
								$this->Page->save($newPageArray);
							}
							$this->Datamanage->saveRow($this->data,$model,false,"edit",$id);
							if($parent>0){
								$oldSrc = $this->Pagegallery->getValue("Pagegallery",$id,"src");
								$smallSrc = "img/".$this->Datamanage->configs->src[$model]."/thumb/".$oldSrc;
								$src = "img/".$this->Datamanage->configs->src[$model]."/".$oldSrc;
								if(!empty($oldSrc) and $beforeoldSrc!=$oldSrc){
									$this->Image->createthumb($src,$smallSrc,"143","105");
								}
							}
							$this->saveTooltip("edited");
							if($parent>0)
								$this->redirect("itemManagement/Pagegallery/list?parent=".$parent);
							else
								$this->redirect("itemManagement/Pagegallery/list?pageconnectedid=".$pageconnectedid);
							die();
		    			case "Portalitem":
							if(!empty($this->data[$model]['page_connectedid']) and empty($this->data[$model]['link'])){
								$link = $this->Page->getValue("Page",$this->data[$model]['page_connectedid'],"link");
								$this->data[$model]['link'] = $link;
							}
							$this->Datamanage->saveRow($this->data,$model,false,"edit",$id);
							$this->saveTooltip("edited");
							$this->redirect("itemManagement/Portalitem/list?page_id=".$this->data[$model]['page_id']);
							die();
							break;
						case "Box":
							$this->Datamanage->saveRow($this->data,$model,false,"edit",$id);
							$this->saveTooltip("edited");
							$type = $this->Box->getValue("Box",$id,"type");
							$page_id = $this->Box->getValue("Box",$id,"type_id");
							$this->redirect("itemManagement/Box/list?type=$type&page_id=$page_id");
							die();
							break;
						case "Drug":
							$this->Datamanage->saveRow($this->data,$model,false,"edit",$id);
							$this->saveTooltip("edited");
							if(isset($this->data[$model]['parent']) and !empty($this->data[$model]['parent']) and $this->data[$model]['parent']>0)
								$this->redirect("itemManagement/Drug/list?parent=".$this->data[$model]['parent']);
							else
								$this->redirect("itemManagement/Drug/list");
							die();
							break;
						case "Gallery":
							$this->Datamanage->saveRow($this->data,$model,false,"edit",$id);
							$this->saveTooltip("edited");
							$type = $this->Gallery->getValue("Gallery",$id,"type");
							$page_id = $this->Gallery->getValue("Gallery",$id,"type_id");
							$this->redirect("itemManagement/Gallery/list?type=$type&page_id=$page_id");
							die();
							break;
						case "Mainitem":
							$this->Datamanage->saveRow($this->data,$model,false,"edit",$id);
							$this->saveTooltip("edited");
							$this->redirect("itemManagement/Mainitem/list?page_id=".$this->data[$model]['page_id']."&type=".$this->data[$model]['type']);
							die();
							break;
						default:
	    					if(in_array($model,$this->configs->config_notAjaxForms)){
	    						$this->Datamanage->saveRow($this->data,$model,false,"edit",$id);
	    						$page_type = $this->Page->getValue("Page",$id,"type");
								$this->checkPagesParamsForModel("Page",$page_type,$id);
	    						$this->saveTooltip("edited");
	    						$this->redirect("itemManagement/$model/list");
								die();
		    				}
							$this->Datamanage->saveRow($this->data,$model,false,"edit",$id);
							$page_type = $this->Page->getValue("Page",$id,"type");
							$this->checkPagesParamsForModel("Page",$page_type,$id);
							break;
					}
					echo "Edited";
				}
				else{
					if(in_array($model,$this->configs->config_notAjaxForms)){
						$this->saveTooltip("require");
						$this->Session->write("data",$this->data[$model]);
						$this->redirect("itemManagement/$model/edit/$id");
						die();
					}
					echo $answer;
				}
				die();
				break;
			case "delete":
				$this->checkPermissions("delete",$model,$id);
				$modelHasPages = array("Article","Event");
				if(in_array($model,$modelHasPages)){
					$page_id = $this->$model->getValue($model,$id,"page_id");
					if(!empty($page_id) and $page_id>0){
						$this->Page->delete($page_id);
					}
				}
				if($this->$model->delete($id))
					echo "Deleted";
				else
					echo "Error";
				die();
				break;
		}
	}
	function loadJsonDataEdit($model,$id){
		if($model=="Assessmentquestion"){
			$this->$model->bindParams("hasMany","Assessmentanswer","Assessmentanswer","","","id,answer,correct","quiestion_id");
		}
		$data = $this->$model->findById($id);
		if($model=="Assessmentquestion"){
			$data[$model]['Assessmentanswer'] = $data['Assessmentanswer'];
		}
		echo json_encode($data[$model]);
		die();
	}
    function getPagesParamsKeys($page_type){
		$pagesParams =  $this->Datamanage->loadFieldsFromXml($this->Datamanage->configs->xml_folder."/".$this->Datamanage->configs->xml_pagesParams);
		if(isset($pagesParams['Items'][inflector::camelize($page_type)]) and !empty($pagesParams['Items'][inflector::camelize($page_type)])){
			return array_keys($pagesParams['Items'][inflector::camelize($page_type)]);
		}
		return false;
	}
	function verify($model,$row_id,$type="false"){
		if(in_array($model,array("Comment","Newsflash"))){
			if($this->$model->hasAny("id='".$row_id."'")){
				$this->$model->id = $row_id;
				$this->$model->saveField("verify",$type);
				echo "Fine";
				die();
			}
		}
	}
	function disableUser($user_id){
   		//$this->checkSession();
   		$this->User->id=$user_id;
   		$this->User->saveField("active","false");
   		die();
   	}
   	function enableUser($user_id){
   		//$this->checkSession();
   		$this->User->id=$user_id;
   		$this->User->saveField("active","true");
   		die();
   	}
   	function checkPagesParamsForModel($model,$page_type,$page_id){
   		if($paramsKeys = $this->getPagesParamsKeys($page_type)){
   			foreach ($paramsKeys as $pkey):
				$pkey = inflector::underscore($pkey);
				if(!isset($this->data[$model][$pkey])){
					continue;
				}
				$file_flag = true;
				if(isset($_FILES) and isset($_FILES['data']['name'][$model]) and isset($_FILES['data']['name'][$model][$pkey])){
					if(!empty($_FILES['data']['name'][$model][$pkey]['tmp_name'])){
						$targetPath = "img/".$this->Datamanage->configs->src[$model]."/";
						$filename = $this->uploadFile($_FILES,$targetPath,$model,$pkey);
						$this->data[$model][$pkey] = str_replace($targetPath,"",$filename);
					}else{
						$file_flag = false;
					}
				}
				if($found = $this->Pages_param->find("page_id=$page_id and Pages_param.key='$pkey'")){
					if($file_flag){
						$this->Pages_param->id = $found['Pages_param']['id'];
						$this->Pages_param->saveField("value",$this->data[$model][$pkey]);
					}
				}
				else{
					$newArray['id']="";
					$newArray['page_id'] = $page_id;
					$newArray['key'] = $pkey;
					$newArray['value'] = $this->data[$model][$pkey];
					$this->Pages_param->save($newArray);
				}
			endforeach;
		}
   	}
   	function changeAjax($model,$field,$value){
   		$xml = $this->Datamanage->loadFieldsFromXml($this->Datamanage->configs->xml_folder."/models/".$model.".xml");
   		$cvalue = inflector::camelize($value);
   		//if(isset($arrayOfFields['Items']['Ajaxload']) and isset($arrayOfFields['Items']['Ajaxload'][][$cvalue])){
			$this->controller->set("ajaxLoad",$arrayOfFields['Items']['Ajaxload']);
		//}
   		//print_r($xml);
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
   	function getSurveyRecords($survey_id=""){
   		if(!is_numeric($survey_id)){
   			$this->redirect("/admin");
   			die();
   		}
   		if(!$found = $this->Survey->find("id='$survey_id'")){
   			$this->redirect("/admin");
   			die();
   		}
		$items = $this->Surveyanswer->query("SELECT answer,COUNT(*) AS count FROM surveyanswers where survey_id='$survey_id' GROUP BY answer");
		$scores = array();
		foreach($items as $item):
			$scores[$item['surveyanswers']['answer']] = $item[0]['count'];
		endforeach;
		$this->set("survey",$found);
		$this->set("scores",$scores);
   	}
}
?>
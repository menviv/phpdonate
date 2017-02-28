<?php
/** admin_controller Controller **/
function loadAdminControllerVars(){
	//$options->config_models = array();
	$options->config_adminType_superadmin_notDeleteIcon = array();
	$options->config_adminType_superadmin_notEditIcon = array();
	$options->config_adminType_superadmin_notAddIcon = array();
	$options->config_adminType_admin_notDeleteIcon = array("Admin");
	$options->config_adminType_admin_notEditIcon = array();
	$options->config_adminType_admin_notAddIcon = array("Admin");
	$options->config_array_edit_icon_click = array();
	$options->config_handlePositionModels = array("Menu"=>"","Drug"=>"","News"=>"","Gallery"=>"","Portalitem"=>"","Mainitem"=>"","Staff"=>"","Pagegallery"=>"");
	$options->config_notAjaxForms = array("Article","Item","Event","Staff","Box","Gallery","Portalitem","Page","Mainitem","Drug","Pagegallery");
	$options->config_direction = "rtl";
	$options->config_langsFile = "/admin.langs/he";
	$options->config_modelFieldsAjaxOrder = array("Menu");
	$options->plugins = array();
	return $options;
}
/** end admin_controller Controller **/
/** datamanage Component**/
function loadDataManageVars(){
	$options->xml_folder = ADMIN_CONFIGS."adminxmls";
	$options->models_xml_folder = "models";
	$options->xml_relation = "relation.xml";
	$options->xml_selects = "selects.xml";
	$options->xml_pagesParams = "Pages_param.xml";
	$options->items_per_page = 30;
	$options->pagesParams = true;
	$options->pagesParamsModels = array();
	
	$options->info = array();
	$options->src = array("Item"=>"uploads/items","Event"=>"uploads/events","Staff"=>"uploads/staff","Box"=>"uploads/box","Gallery"=>"uploads/gallery","Portalitem"=>"uploads/portal","Page"=>"uploads/pages","Mainitem"=>"uploads/mainitems","Drug"=>"uploads/drugs","Pagegallery"=>"uploads/pagegallery");
	$options->srcKey = array("Item"=>array("src"),"Event"=>array("image"),"Staff"=>array("thumb","head"),"Box"=>array("src"),"Gallery"=>array("thumb","src"),"Portalitem"=>array("src"),"Page"=>array("mainintems_thumb"),"Mainitem"=>array("src"),"Drug"=>array("src"),"Pagegallery"=>array("src"));
	
	$options->fieldsType = array("Admin"=>array("password"=>"password"),"Event"=>array("dateEvent"=>"date"),"News"=>array("dateNews"=>"date"));	 /*file types such as array("model"=>array("fieldname"=>"typename")) */
	
	return $options;
}
/** end datamanage Component**/
?>
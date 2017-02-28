<?php //$ajax = array("Client"=>"/clients","User"=>"/users");?>
<?php 
	if(!isset($formAction) or empty($formAction))
		$formAction = "/admin/dataManage/$model/editstore/$edit_id";
?>
<?php 
	if(isset($ajax[$model]))
		$AjaxUrl = $ajax[$model];
	else 
		$AjaxUrl = false;
?>
<?php //echo $quatro->makeFile("user.name",array("labelClass"=>"right names","labelName"=>"שם","labelFor"=>"userName","inputClass"=>"right inputs rtl","empty"=>true,"value"=>array("on"=>"true","of"=>"false")));?>
<?php echo $this->element("newdata",array("formAction"=>$html->url($formAction),"editForm"=>"true","Ajax"=>$AjaxUrl));?>
<?php //echo $form->create('User'); ?>
<?php //echo $form->inputs(); ?>
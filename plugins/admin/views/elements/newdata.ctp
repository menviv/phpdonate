<?php echo $this->element('tinymce',array('preset' => 'basic')); ?>
<?php 
	if(!isset($arrayOfFields[0])){
		$newArrayOfFields[0] = $arrayOfFields;
		$arrayOfFields = "";
		$arrayOfFields = $newArrayOfFields;
	}
	if(isset($stages)){
		if(!isset($currentStage)) $currentStage="1";
	}
?>
<div id="neweditformContainer">
	<form method="post" action="<?php echo $formAction;?>" enctype="multipart/form-data" id="newDataForm">
		<?php if($model=="Page"){?>
			<?php //echo $form->hidden("$model.type",array("value"=>$page_type));?>
		<?php }?>
		<?php 
			if($model=="Menu"){
				if(isset($_GET['type']))
					echo $form->hidden("$model.type",array("value"=>$_GET['type']));
				if(isset($_GET['page_connected_id']))
					echo $form->hidden("$model.page_connected_id",array("value"=>$_GET['page_connected_id']));
				if(isset($_GET['parent_id']))
					echo $form->hidden("$model.parent_id",array("value"=>$_GET['parent_id']));
			}
			if($model=="Box"){
				if(isset($_GET['type']))
					echo $form->hidden("$model.type",array("value"=>$_GET['type']));
				if(isset($_GET['page_id']))
					echo $form->hidden("$model.type_id",array("value"=>$_GET['page_id']));
			}
			if($model=="Question"){
				if(isset($_GET['page_id']))
					echo $form->hidden("$model.page_id",array("value"=>$_GET['page_id']));
			}
			if($model=="Gallery"){
				if(isset($_GET['type']))
					echo $form->hidden("$model.type",array("value"=>$_GET['type']));
				if(isset($_GET['page_id']))
					echo $form->hidden("$model.type_id",array("value"=>$_GET['page_id']));
			}
			if($model=="Portalitem"){
				if(isset($_GET['page_id']))
					echo $form->hidden("$model.page_id",array("value"=>$_GET['page_id']));
				else
					echo $form->hidden("$model.page_id",array("value"=>$this->data[$model]['page_id']));
				
			}
			if($model=="Mainitem"){
				if(isset($_GET['page_id']))
					echo $form->hidden("$model.page_id",array("value"=>$_GET['page_id']));
				else
					echo $form->hidden("$model.page_id",array("value"=>$this->data[$model]['page_id']));
				if(isset($_GET['type']))
					echo $form->hidden("$model.type",array("value"=>$_GET['type']));
				else
					echo $form->hidden("$model.type",array("value"=>$this->data[$model]['type']));
				
			}
			if($model=="Article"){
				if(isset($_GET['parent_id']))
					echo $form->hidden("$model.parent_id",array("value"=>$_GET['parent_id']));
				else
					echo $form->hidden("$model.parent_id",array("value"=>$this->data['Article']['parent_id']));
				if(isset($startLink)){
					echo $form->hidden("$model.startlink",array("value"=>$this->data['Article']['startlink']));
				}
			}
			if($model=="Answer"){
				if(isset($_GET['question_id']))
					echo $form->hidden("$model.question_id",array("value"=>$_GET['question_id']));
				else
					echo $form->hidden("$model.question_id",array("value"=>$this->data['Answer']['question_id']));
			}
			if($model=="Drug"){
				if(isset($_GET['parent']))
					echo $form->hidden("$model.parent",array("value"=>$_GET['parent']));
				else
					echo $form->hidden("$model.parent",array("value"=>isset($this->data['Drug']['parent']) ? $this->data['Drug']['parent'] : 0));
			}
			if($model=="Pagegallery"){
				if(isset($_GET['pageconnectedid']))
					echo $form->hidden("$model.pageconnectedid",array("value"=>$_GET['pageconnectedid']));
				if(isset($_GET['parent']))
					echo $form->hidden("$model.parent",array("value"=>$_GET['parent']));
			}
		?>
		<?php foreach ($arrayOfFields as $properties):?>
			<?php if((isset($properties['stage']) and $properties['stage']!=$currentStage) or isset($properties['additional'])){?>
				<?php 
				if(isset($properties['additional'])){
					if(isset($editDataId) and is_numeric($editDataId) and $editDataId>0) //only for edit
						$additionalElement = true;
				}
				?>
			<?php }else{?>
				<?php if(isset($properties['tab']) and $properties['tab']=="true"){?>
					<div class="left top_tabData"><a href="javascript:void(0);"><?php echo $properties['topname'];?></a></div>
				<?php }else{?>
					<div class="both"></div>
					<div>
					<?php $toggle = "false"; if(isset($properties['toggle']) and $properties['toggle']=="true") $toggle="true";?>
					<?php if($toggle=="true"){?>
						<div class="top_newData"><a href="javascript:void(0)" onclick="openToggle(this);"><?php echo $properties['topname'];?></a></div>
					<?php }else{?>
						<div class="top_newData"><?php echo $properties['topname'];?></div>
					<?php }?>
				<?php foreach ($properties as $key=>$value):?>
					<?php if($key!="topname" and $key!="stage" and $key!="totalstages" and $key!="toggle"){?>
						<?php $key = Inflector::underscore($key);?>
						<?php 
						if(is_array($value) and isset($value['additional'])){
							echo $this->element("additional/".$value['additional'],array("key"=>$key,"value"=>$value));
						}
						else{
							echo $this->element("list/newdataitem",array("key"=>$key,"value"=>$value,"toggle"=>$toggle));
						}
						?>
						<?php ?>
					<?php }?>
				<?php endforeach;?>
				</div>
				<?php }?>
			<?php }?>
		<?php endforeach;?>
		<?php if(!isset($additionalElement)){?>
			<div class="submitform">
				<div class="left" id="errorForm"></div>
				<?php if(isset($stages)){?>
					<div class="right stagesnext"><?php echo $form->submit("",array("div"=>false));?></div>
					<div class="right stagescancel"><input type="button" value="" /></div>
				<?php }else{?>
					<?php if($model=="Article" and 1==2){?>
						<div class="left previewLink"><a href="javascript:void(0);" onclick="previewItem()"><?php echo _LANG_DATA_PREVIEW;?></a></div>	
					<?php }?>
					<div class="right"><?php echo $form->submit(_LANG_DATA_SUBMIT,array("div"=>false));?></div>
				<?php }?>
				<div class="both"></div>
			</div>
		<?php }?>
		<?php if(isset($currentStage)){?>
			<input type="hidden" name="step" value="<?php echo $currentStage;?>" />
		<?php }?>
	</form>
	<?php 
		if(isset($additionalElement) and $additionalElement===true)
			echo $this->element("additional/".$properties['additional']);
	?>
</div>
<?php if(isset($Ajax) and !empty($Ajax) and $Ajax!=false){?>
	<script type="text/javascript">
		AjaxUrl = "<?php echo $Ajax;?>".replace(/&amp;/g, '&');
		Event.observe('newDataForm','submit',sendNewDataForm);
	</script>
<?php }?>
<script type="text/javascript">
		model = "<?php echo $model;?>";
</script>
<?php /*if(isset($ajaxLoad) and !empty($ajaxLoad)){?>
	<?php foreach($ajaxLoad as $ajaxLoadItemKey=>$ajaxLoadItemValue):?>
		<script type="text/javascript">
			Event.observe('<?php echo $model.$ajaxLoadItemKey;?>','change',loadAjax);
		</script>
	<?php endforeach;?>
<?php }*/?>
<?php if($model=="Page"){?>
<script type="text/javascript">
	testTemplate();
	jQuery("#PageType").change(function(){
		testTemplate();
	});
	function testTemplate(){
		if(jQuery("#PageType").val()=="faq" || jQuery("#PageType").val()=="mainarticle" || jQuery("#PageType").val()=="article" || jQuery("#PageType").val()=="donate"){
			jQuery(".langRow").animate({height:"show"});
		}else{
			jQuery(".langRow").animate({height:"hide"});
		}
	}
</script>
<?php }?>
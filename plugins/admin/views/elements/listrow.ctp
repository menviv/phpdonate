<?php 
$additionalClass = "";
if($model=="Comment" or $model=="Newsflash"){
	if($row[$model]['verify']=="true")
		$additionalClass = "row_list_green";
	if($row[$model]['verify']=="false")
		$additionalClass = "row_list_red";
}
?>
<tr id="row_<?php echo $row[$model]['id'];?>" class="<?php echo $additionalClass;?> listrowlist<?php if($counter%2==1) echo " row_list_current";?><?php if(isset($fieldForPosition)) echo " positiontype_".$row[$model][$fieldForPosition];?>">
	<?php if(1==2){?><td><input type="checkbox" /></td><?php }?>
	<?php foreach ($arrayOfFields as $key=>$properties):?>
		<?php
			$oldKey = $key;
			if($key!="DateAdd")
				$key = Inflector::underscore($key);
			else
				$key = "dateAdd";
		?>
		<?php if($properties['list']=="true"){?>
			<td class="<?php echo $classlist;?> col_<?php echo $key;?>" id="col_<?php echo $key;?>_<?php echo $row[$model]['id'];?>">
				<?php 
					if(isset($row[$model][$key]))
						$value=$row[$model][$key];
					else
						$value="";
				?>
				<?php 
					if(isset($$oldKey)){
						$arr=$$oldKey;
						if(isset($arr[$value]))
							$value=$arr[$value];
						else 
							$value = "";
					}
					$keyToCheck = Inflector::camelize($key);
					if(isset($selects[$keyToCheck])){
						$value = $selects[$keyToCheck][$value];
					}
				?>
				<?php 
				switch ($key){
					case "status":
						if($value=="Active")
							$value = "Enable";
						else 
							$value = "Disable";
						break;
					case "file":
						$value ='<div><a href="'.$html->url("/$value").'">'.$html->image("adminlayout/icons/attach.png").'</a></div>';
						break;
					case "url":
						if($model=="Icon")
							$value = "<img src='$value' alt='' title='' />";
						break;
				}
				if(isset($properties['type']) and $properties['type']=="date")
					if($value!="0000-00-00 00:00:00" and !empty($value)){
						$value = date("d.m.y",strtotime($value));
					}
					else 
						$value = "";
				?>
				<?php echo $value;?>
			</td>
		<?php }?>
	<?php endforeach;?>
	<?php if(isset($handle)){?>
		<?php 
			if(isset($fieldForPosition)){
				if(isset($uppositiontype))
					$lastuppositiontype = $uppositiontype;
				else
					$lastuppositiontype = $row[$model][$fieldForPosition];
				$uppositiontype = $row[$model][$fieldForPosition];
				if($uppositiontype==$lastuppositiontype)
					$uppositionFlag = false;
				else
					$uppositionFlag = true;
				
				if(isset($downpositiontype))
					$lastdownpositiontype = $downpositiontype;
				else
					$lastdownpositiontype = $data[$counter-1][$model][$fieldForPosition];
				if(isset($data[$counter][$model][$fieldForPosition]))
					$downpositiontype = $data[$counter][$model][$fieldForPosition];
				else
					$downpositiontype = -1;
				if($downpositiontype==$lastdownpositiontype)
					$downpositionFlag = false;
				else
					$downpositionFlag = true;
				
				
				
			}
		?>
		<td class="<?php echo $classlist;?>">
			<div class="left orderIcon orderIconUp"><a href="javascript:void(0);" onclick="movePos('up','<?php echo $row[$model]['id'];?>');"<?php if($row[$model]['position']==1 or(isset($uppositionFlag) and $uppositionFlag)) echo " style='display:none;'";?>><?php echo $html->image("/admin/img/icons/arrow_up.png");?></a></div>
			<div class="left orderInput"><?php echo $form->input("list.order.".$row[$model]['id'],array("label"=>false,"div"=>false,"value"=>$row[$model]['position']));?></div>
			<div class="left orderIcon orderIconDown"><a href="javascript:void(0);" onclick="movePos('down','<?php echo $row[$model]['id'];?>');"<?php if(isset($downpositionFlag) and $downpositionFlag) echo " style='display:none;'";?>><?php echo $html->image("/admin/img/icons/arrow_down.png");?></a></div>
			<div class="both"></div>
		</td>
	<?php }?>
	<?php if(in_array($model,array("Page","Event","Menu","Question","Drug","Survey","Pagegallery"))){?>
	<td class="<?php echo $classlist;?> modulesList">
		<?php 
			if($model=="Page"){
				switch($row[$model]['type']){
					case "home":
						?><a href="<?php echo $html->url("/admin/itemManagement/Gallery/list/?type=home&page_id=".$row[$model]['id']);?>"><?php echo $html->image("/admin/img/icons/photos.png",array("class"=>"png","alt"=>"","title"=>"גלריה"));?></a><?php
						?><a href="<?php echo $html->url("/admin/itemManagement/Survey/list/");?>"><?php echo $html->image("/admin/img/icons/report.png",array("class"=>"png","alt"=>"","title"=>"סקר"));?></a><?php
						?><a href="<?php echo $html->url("/admin/itemManagement/Box/list/?type=homebottom&page_id=".$row[$model]['id']);?>"><?php echo $html->image("/admin/img/icons/page_white_stack.png",array("class"=>"png","alt"=>"","title"=>"אייטמים"));?></a><?php
						break;
					case "mainarticle":
						?><a href="<?php echo $html->url("/admin/itemManagement/Portalitem/list/?page_id=".$row[$model]['id']);?>"><?php echo $html->image("/admin/img/icons/images.png",array("class"=>"png","alt"=>"","title"=>"פורטל"));?></a><?php
						?><a href="<?php echo $html->url("/admin/itemManagement/Menu/list/?type=category&page_id=".$row[$model]['id']);?>"><?php echo $html->image("/admin/img/icons/application_view_icons.png",array("class"=>"png","alt"=>"","title"=>"קטגוריות"));?></a><?php
						?><a href="<?php echo $html->url("/admin/itemManagement/Box/list/?type=category&page_id=".$row[$model]['id']);?>"><?php echo $html->image("/admin/img/icons/page_white_stack.png",array("class"=>"png","alt"=>"","title"=>"אייטמים"));?></a><?php
						break;
					case "mainitems":
						?><a href="<?php echo $html->url("/admin/itemManagement/Mainitem/list/?page_id=".$row[$model]['id']."&type=right");?>"><?php echo $html->image("/admin/img/icons/images.png",array("class"=>"png","alt"=>"","title"=>"פורטל ימין"));?></a><?php
						?><a href="<?php echo $html->url("/admin/itemManagement/Mainitem/list/?page_id=".$row[$model]['id']."&type=left");?>"><?php echo $html->image("/admin/img/icons/images.png",array("class"=>"png","alt"=>"","title"=>"פורטל שמאל"));?></a><?php
						if($row[$model]['parent']==0){
						?><a href="<?php echo $html->url("/admin/itemManagement/Menu/list/?type=category&page_id=".$row[$model]['id']);?>"><?php echo $html->image("/admin/img/icons/application_view_icons.png",array("class"=>"png","alt"=>"","title"=>"קטגוריות"));?></a><?php
						?><a href="<?php echo $html->url("/admin/itemManagement/Box/list/?type=category&page_id=".$row[$model]['id']);?>"><?php echo $html->image("/admin/img/icons/page_white_stack.png",array("class"=>"png","alt"=>"","title"=>"אייטמים"));?></a><?php
						}
						break;
					case "faq":
						?><a href="<?php echo $html->url("/admin/itemManagement/Question?parent=".$row[$model]['id']);?>"><?php echo $html->image("/admin/img/icons/page_white_stack.png",array("class"=>"png","alt"=>"","title"=>"שאלות"));?></a><?php
						break;
					case "gallery":
						?><a href="<?php echo $html->url("/admin/itemManagement/Pagegallery/list/?pageconnectedid=".$row[$model]['id']);?>"><?php echo $html->image("/admin/img/icons/photos.png",array("class"=>"png","alt"=>"","title"=>"גלריה"));?></a><?php
						break;
					case "drugs":
						?><a href="<?php echo $html->url("/admin/itemManagement/Drug/list/");?>"><?php echo $html->image("/admin/img/icons/page_white_stack.png",array("class"=>"png","alt"=>"","title"=>"תרופות"));?></a><?php
						break;
					case "events":
						?><a href="<?php echo $html->url("/admin/itemManagement/Event/list/");?>"><?php echo $html->image("/admin/img/icons/date.png",array("class"=>"png","alt"=>"","title"=>"אירועים"));?></a><?php
						break;
					case "contact":
						?><a href="<?php echo $html->url("/admin/itemManagement/Emailslayout/list/");?>"><?php echo $html->image("/admin/img/icons/email_link.png",array("class"=>"png","alt"=>"","title"=>"אימיילים"));?></a><?php
						break;
					case "staff":
						?><a href="<?php echo $html->url("/admin/itemManagement/Staff/list/");?>"><?php echo $html->image("/admin/img/icons/vcard.png",array("class"=>"png","alt"=>"","title"=>"אנשי צוות"));?></a><?php
						break;
					
				}
			}
			if($model=="Event"){
				?><a href="<?php echo $html->url("/admin/itemManagement/Gallery/list/?type=event&page_id=".$row[$model]['id']);?>"><?php echo $html->image("/admin/img/icons/photos.png",array("class"=>"png","alt"=>"","title"=>"גלריה"));?></a><?php
			}
			if($model=="Survey"){
				?><a href="<?php echo $html->url("/admin/getSurveyRecords/".$row[$model]['id']);?>"><?php echo $html->image("/admin/img/icons/chart_pie.png",array("class"=>"png","alt"=>"","title"=>"תוצאות"));?></a><?php
			}
			if($model=="Pagegallery" and (is_null($row[$model]['parent']) or ($row[$model]['parent'])==0)){
				?><a href="<?php echo $html->url("/admin/itemManagement/Pagegallery/list/?parent=".$row[$model]['id']);?>"><?php echo $html->image("/admin/img/icons/photos.png",array("class"=>"png","alt"=>"","title"=>"גלריה"));?></a><?php
			}
			if($model=="Menu"){
				switch($row[$model]['type']){
					case "category":
						if(is_null($row[$model]['parent_id'])){
							?><a href="<?php echo $html->url("/admin/itemManagement/Menu/list/?parent_id=".$row[$model]['id']);?>"><?php echo $html->image("/admin/img/icons/page_white_stack.png",array("class"=>"png","alt"=>"","title"=>"עמודים מקושרים"));?></a><?php
						}
						break;
					case "footer":
						if(is_null($row[$model]['parent_id'])){
							?><a href="<?php echo $html->url("/admin/itemManagement/Menu/list/?parent_id=".$row[$model]['id']);?>"><?php echo $html->image("/admin/img/icons/page_white_stack.png",array("class"=>"png","alt"=>"","title"=>"עמודים מקושרים"));?></a><?php
						}
						break;
					
				}
			}
			if($model=="Question"){
				?><a href="<?php echo $html->url("/admin/itemManagement/Answer/list/?question_id=".$row[$model]['id']);?>"><?php echo $html->image("/admin/img/icons/page_white_stack.png",array("class"=>"png","alt"=>"תשובות מקושרות","title"=>"תשובות מקושרות"));?></a><?php
			}
			if($model=="Drug"){
				?><a href="<?php echo $html->url("/admin/itemManagement/Drug/list/?parent=".$row[$model]['id']);?>"><?php echo $html->image("/admin/img/icons/page_white_stack.png",array("class"=>"png","alt"=>"תרופות מקושרות","title"=>"תרופות מקושרות"));?></a><?php
			}
		?>
	</td>
	<?php }?>
	<td class="<?php echo $classlist;?>">
		<?php if(!in_array($model,$array_not_edit_icon)){?>
			<?php if(isset($array_edit_icon_click) and isset($array_edit_icon_click[$model])){?>
				<a href="javascript:void(0);" onclick="<?php echo $array_edit_icon_click[$model];?>('<?php echo $row[$model]['id'];?>')"><?php echo $html->image("/admin/img/icons/page_white_edit.png",array("class"=>"png","alt"=>"Edit","title"=>"Edit"));?></a>
			<?php }else{?>
				<?php 
					$editLink = "$model/edit/".$row[$model]['id'];
					if($model=="Menu" and $row[$model]['type']=="category" and is_numeric($row[$model]['parent_id'])){
						if(is_numeric($row[$model]['page_id'])){
							$editLink = "Article/edit/".$row[$model]['article_id'];
						}else{
							$editLink = "";
						}
					}
				?>
				<?php if(!empty($editLink)){?>
					<a href="<?php echo $html->url("/admin/itemManagement/".$editLink);?>"><?php echo $html->image("/admin/img/icons/page_white_edit.png",array("class"=>"png","alt"=>"Edit","title"=>"Edit"));?></a>
				<?php }?>
			<?php }?>
		<?php }?>
		<?php if(!in_array($model,$array_not_delete_icon)){?>
			<a href="javascript:void(0);" onclick="deleteRow('<?php echo $row[$model]['id'];?>','<?php echo $model;?>');"><?php echo $html->image("/admin/img/icons/delete.png",array("class"=>"png","alt"=>"Delete","title"=>"Delete"));?></a>
		<?php }?>
	</td>
</tr>
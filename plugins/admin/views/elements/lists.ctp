<?php 
if(!isset($classheader))
	$classheader="listHeaders";
if(!isset($classlist))
	$classlist="listData";
if(!isset($classtable))
	$classtable="listtable";
?>
<table class="<?php echo $classtable;?>" id="listtablelist" cellpadding="0" cellspacing="0">
	<thead>
	<tr>
		<?php if(1==2){?><td class="<?php echo $classheader;?>"><input type="checkbox" /></td><?php }?>
		<?php $colspanCounter=1;?>
		<?php foreach ($arrayOfFields as $key=>$properties):?>
			<?php if($properties['list']=="true"){?>
				<?php if(isset($ajaxSort)){?>
					<td class="<?php echo $classheader;?>"><a href="javascript:orderByData('<?php echo Inflector::underscore($key);?>');"><?php echo $properties['name'];?></a></td>
				<?php }else{?>
					<td class="<?php echo $classheader;?>"><?php echo $properties['name'];?></td>
				<?php }?>
				<?php $colspanCounter++;?>
			<?php }?>
		<?php endforeach;?>
		<?php
			if(isset($handle)){
				?><td class="<?php echo $classheader;?>"><div class="left"><?php echo _LANG_LIST_ORDER;?></div><div class="left" style="margin:9px 0 0 5px;"><a href="javascript:void(0);" onclick="sendPositionUpdate()"><?php echo $html->image("/admin/img/icons/accept.png");?></a></div><div class="both"></div></td><?php
			}
		?>
		<?php if(in_array($model,array("Page","Event","Menu","Question","Drug","Survey","Pagegallery"))){?><td class="<?php echo $classheader;?>">מודולים ואייטמים מקושרים</td><?php }?>
		<td class="<?php echo $classheader;?>"><?php echo _LANG_LIST_MANAGE;?></td>
	</tr>
	</thead>
	<tbody id="listtablelistbody">
	<?php $counter=1;?>
	<?php foreach ($data as $row):?>
		<?php echo $this->element("listrow",array("row"=>$row,"counter"=>isset($commentTop) ? $commentTop+1 - $counter : $counter,"classlist"=>$classlist));?>
		<?php $counter++;?>
	<?php endforeach;?>
	</tbody>
</table>
<script type="text/javascript">
	deleteUrl = "<?php echo $html->url("/admin/itemManagement/");?>";
	adminUrlAction = "<?php echo $html->url("/admin");?>";
</script>
<?php if(isset($handle)){?>
<script type="text/javascript">
	sorturl = '<?php echo $html->url("/admin/setPositionAjax/$model");?>';
	//createSort();
</script>
<?php }?>
<script type="text/javascript">
	$$("tr.listrowlist").invoke('observe', 'mouseover', function(ele){this.addClassName("listTdOver");});
	$$("tr.listrowlist").invoke('observe', 'mouseout', function(ele){this.removeClassName("listTdOver");});
</script>
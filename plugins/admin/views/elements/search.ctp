<?php 
if(isset($searchFields) and !empty($searchFields)){
	if(!isset($pageAddNew))
		$pageAddNew = "/admin/itemManagement/$model/new";
?>
	<div id="searchList">
		<form action="<?php echo $html->url("/admin/itemManagement/$model");?>" method="get" id="adminSearchData">
			<div class="left" style="margin-top:2px;"><?php echo $form->select("search.fields",$searchFields,"",array("name"=>"searchfields","empty"=>false));?></div>
			<div class="left searchInput" style="margin-top:1px;"><div id="searchbtn"></div><?php echo $form->input("search.value",array("div"=>false,"label"=>false,"name"=>"searchvalue"));?></div>
			<div class="left" style="margin-top:3px;"><?php echo $form->submit("Go",array("div"=>false));?></div>
			<?php if(!in_array($model,$array_not_add_icon)){?><div class="right pageAddItem"><?php echo $html->link(_LANG_LIST_ADDITEM,$pageAddNew);?></div><?php }?>
			<div class="both"></div>
		</form>
	</div>
	<?php if(isset($searchVar)){?>
		<script type="text/javascript">
			searchVar = "<?php echo $searchVar;?>";
		</script>
	<?php 
		}
}else{?>
	<div id="searchList">
	<?php if(isset($pageAddNew)){?>
		<?php if(!in_array($model,$array_not_add_icon)){?><div class="right pageAddItem"><?php echo $html->link(_LANG_LIST_ADDITEM,$pageAddNew);?></div><?php }?>
		<div class="both"></div>
	<?php }else{?>
		<?php if(!in_array($model,$array_not_add_icon)){?><div class="right pageAddItem"><?php echo $html->link(_LANG_LIST_ADDITEM,"/admin/itemManagement/$model/new");?></div><?php }?>
		<div class="both"></div>
	<?php }?>
	</div>
<?php }?>
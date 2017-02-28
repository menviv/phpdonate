<div id="sideRight" class="right">
	<?php if(isset($rightMenu)){?>
		<?php foreach($rightMenu as $category):?>
			<?php echo $this->element("sideRightCategory",array("category"=>$category));?>
			<div class="sideRightSep"></div>
		<?php endforeach;?>
	<?php }?>
	<?php if(isset($boxCats)){?>
	<div id="sideRightSideArticleItems">
		<?php foreach($boxCats as $boxCat):?>
			<?php echo $this->element("sideRightSideArticleItem",array("item"=>$boxCat));?>
		<?php endforeach;?>
	</div>
	<?php }?>
</div>
<script type="text/javascript">
	$$('div.sideRightSideArticleItem').invoke('observe', 'click', changeLinkLocation);
</script>
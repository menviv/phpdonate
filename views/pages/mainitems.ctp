<?php echo $this->element("sideRight");?>
<div id="mainitemsPage" class="leftSideSmall right">
	<?php echo $this->element("breadcrumbs");?>
	<div id="mainitemsPageTop">
		<div id="mainitemsPageTopTitle"><?php echo $currentPageData['Page']['pname'];?></div>
		<div id="mainitemsPageTopImage"><?php echo $html->image("uploads/pages/".$currentPageData['Pages_param']['mainintems_thumb']);?></div>
		<div id="mainitemsPageTopText"><?php echo $currentPageData['Page']['content'];?></div>
	</div>
	<div id="pageShareLinks">
		<?php echo $this->element("shareRow");?>
		<div class="both"></div>
	</div>
	<div class="pageShareLinksSep"></div>
	<div id="mainitemsPageInner">
		<div class="right" id="mainitemsPageInnerRight">
			<?php foreach($rightItems as $rightItem):?>
				<?php echo $this->element("mainitemright",array("item"=>$rightItem));?>
			<?php endforeach;?>
		</div>
		<div class="right" id="mainitemsPageInnerLeft">
			<?php foreach($leftItems as $leftItem):?>
				<?php echo $this->element("mainitemleft",array("item"=>$leftItem));?>
			<?php endforeach;?>
		</div>
		<div class="both"></div>
	</div>
</div>
<div class="both"></div>
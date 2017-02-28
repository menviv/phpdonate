<?php echo $this->element("sideRight");?>
<div id="articlePage" class="leftSideSmall right">
	<?php echo $this->element("breadcrumbs");?>

		<div id="reditLogo"></div>

	<div id="pageShareLinks">
		<?php echo $this->element("shareRow");?>
		<div class="both"></div>
	</div>
	<div class="pageShareLinksSep"></div>
	<div id="articlePageInner" class="reditContent">
		<div id="articlePageText"><?php echo $this->replaceItem($currentPageData['Page']['content']);?></div>
	</div>
</div>
<div class="both"></div>
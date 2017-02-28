<?php echo $this->element("sideRight");?>
<div id="galleryPage" class="leftSideSmall right">
	<?php echo $this->element("breadcrumbs");?>
	<div id="mainarticlePageTopTitle"><?php echo $currentPageData['Page']['pname'];?></div>
	<div id="pageShareLinks">
		<?php echo $this->element("shareRow");?>
		<div class="both"></div>
	</div>
	<div class="pageShareLinksSep"></div>
	<div id="galleryPageThumbs">
		<?php $counter = 1;?>
		<?php foreach($galleries as $item):?>
			<?php echo $this->element("galleryItem",array("counter"=>$counter,"item"=>$item));?>
			<?php $counter++;?>
		<?php endforeach?>
		<div class="both"></div>
	</div>
</div>
<div class="both"></div>
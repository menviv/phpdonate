<?php echo $this->element("indexRight");?>
<div id="indexPage" class="leftSide right">
	<div id="indexGallery">
		<div id="galleryPaginate">
			<div id="galleryPaginateTitle" class="right"><?php //echo $galleryImages[0]['Gallery']['name'];?></div>
			<?php $counter = 1;?>
			<?php foreach($galleryImages as $galleryImage):?>
				<div class="right galleryPaginateBullet<?php if($counter==1) echo " galleryPaginateBulletSel";?>" id="bulletImage<?php echo $counter;?>"></div>
				<?php $counter++;?>
			<?php endforeach;?>
			<div class="both"></div>
		</div>
		<div id="galleryItems">
			<?php $counter = 1;?>
			<?php foreach($galleryImages as $galleryImage):?>
				<?php
				$findme   = 'http://';
				$pos = strpos($galleryImage['Gallery']['link'], $findme);
				$pos2 = strpos($galleryImage['Gallery']['link'], "https://");
				if($pos === false and $pos2===false){
					$galleryImage['Gallery']['link'] = "/".$galleryImage['Gallery']['link'];
				}
				?>
				<div id="galleryItem<?php echo $counter;?>" class="galleryItem"<?php if($counter!=1) echo " style='display:none'";?>>
					<div class="galleryItemImage"><a href="<?php echo $html->url($galleryImage['Gallery']['link']);?>"><?php echo $html->image("uploads/gallery/".$galleryImage['Gallery']['thumb']);?></a></div>
					<div class="galleryItemTextInner">
						<div class="galleryItemTitle"><?php if($galleryImage['Gallery']['id']!=62) echo $html->link($galleryImage['Gallery']['name'],$galleryImage['Gallery']['link']);?></div>
						<div class="galleryItemText"><?php echo $galleryImage['Gallery']['content'];?></div>
					</div>
				</div>
				<?php $counter++;?>
			<?php endforeach;?>
		</div>
	</div>
	<div id="indexContent">
		<?php $counter = 1;?>
		<?php foreach($boxItems as $boxItem):?>
			<?php echo $this->element("articlepreview",array("boxItem"=>$boxItem,"counter"=>$counter));?>
			<?php $counter++;?>
		<?php endforeach;?>
		<div class="both"></div>
	</div>
</div>
<div class="both"></div>
<script type="text/javascript">
	currentImage = 1;
	duration = 4000;
	indexStrips = <?php echo json_encode($galleryImages);?>;
	$$('div.galleryPaginateBullet').invoke('observe', 'click', changeIndexImage);
	$$('div.articleSmallItem').invoke('observe', 'click', changeLinkLocation);
	$$('div.galleryItem').invoke('observe', 'click', changeLinkLocation);
	var indexAutoTime = setTimeout("changeIndexImageAuto()",duration);
	$j('#galleryItems').hover(
		function(){
			stopIndexImage();
		},
		function(){
			continueIndexImage();
		}
	);
</script>
<?php echo $this->element("sideRight");?>
<div id="mainarticlePage" class="leftSideSmall right">
	<?php echo $this->element("breadcrumbs");?>
	<div id="mainarticlePageTopTitle"><?php echo $currentPageData['Page']['pname'];?></div>
	<div id="pageShareLinks">
		<?php echo $this->element("shareRow");?>
		<div class="both"></div>
	</div>
	<div class="pageShareLinksSep"></div>
	<div id="mainarticlePageThumbs">
		<?php $counter=0;?>
		<?php $close=true;?>
		<?php foreach($portal as $item):?>
			<?php if($counter%3==0){?>
			<?php $close=false;?>
			<div class="mainarticlePageThumbsRow">
			<?php }?>
				<?php echo $this->element("mainarticlePageThumb",array("item"=>$item));?>
			<?php if(($counter+1)%3==0){?>
				<?php $close=true;?>
				<div class="both"></div>
			</div>
			<?php }?>
			<?php $counter++;?>
		<?php endforeach;?>
		<?php if($close==false){?>
			<div class="both"></div>
		</div>
		<?php }?>
	</div>
</div>
<div class="both"></div>
<script type="text/javascript">
	$$('div.mainarticlePageThumb').invoke('observe', 'click', changeLinkLocation);
</script>
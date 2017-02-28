<div class="galleryinnerPageItem right"<?php if($counter%4==0) echo " style='margin-left:0;'";?>>
	<a href="<?php echo $html->url("/img/uploads/pagegallery/".$item['Pagegallery']['src']);?>" class="galleryItemHref" rel="group">
		<?php echo $html->image("uploads/pagegallery/thumb/".$item['Pagegallery']['src'],array("alt"=>"","title"=>""));?>
		<?php /*<span class="outer"><span class="middle"><span class="inner"></span></span></span>*/?>
	</a>
	<div class="galleryinnerPageItemBtns">
		<div class="right galleryinnerPageItemTitle"><?php echo $item['Pagegallery']['title'];?></div>
		<div class="left galleryinnerPageItemShare"><a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo "http://".$_SERVER['HTTP_HOST'].$this->base.$html->url("/img/uploads/pagegallery/".$item['Pagegallery']['src']);?>" target="_blank"><?php echo $html->image("layout/facebooksharegall.png",array("alt"=>"שתף בפייסבוק","title"=>"שתף בפייסבוק"));?></a></div>
		<div class="both"></div>
	</div>
</div>
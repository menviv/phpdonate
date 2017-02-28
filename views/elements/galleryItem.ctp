<div class="galleryPageItem right"<?php if($counter%3==0) echo " style='margin-left:0;'";?>>
	<a href="<?php echo $html->url("/".$item['Pagegallery']['link']);?>">
	<span class="galleryPageItemBg"></span>
	<span class="galleryPageItemImage"><?php echo $html->image("uploads/pagegallery/".$item['Pagegallery']['src']);?></span>
	<span class="galleryPageItemText"><?php echo $item['Pagegallery']['title'];?></span>
	</a>
</div>
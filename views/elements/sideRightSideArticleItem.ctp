<div class="sideRightSideArticleItem">
	<div class="sideRightSideArticleItemImageContainer">
		<?php if(!empty($item['Box']['src'])){?>
			<div class="sideRightSideArticleItemImage"><a href="<?php echo $html->url("/".$item['Box']['link']);?>"><?php echo $html->image("uploads/box/".$item['Box']['src']);?></a></div>
		<?php }else{?>
			<div class="sideRightSideArticleItemImage"><a href="<?php echo $html->url("/".$item['Box']['link']);?>"><?php echo $html->image("layout/portalimage.jpg",array("style"=>"margin-top:12px"));?></a></div>
		<?php }?>
		<div class="sideRightSideArticleItemBackOver"></div>
		<div class="sideRightSideArticleItemTitle"><?php echo $html->link($item['Box']['name'],"/".$item['Box']['link']);?></div>
	</div>
	<div class="sideRightSideArticleItemText"><?php echo $item['Box']['text'];?></div>
	<div class="sideRightSideArticleItemBottom"></div>
</div>
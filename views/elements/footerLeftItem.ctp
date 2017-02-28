<div class="right footerBottomLeftItem">
	<h4 class="footerBottomLeftItemTitle"><?php echo $html->link($footerItem['Menu']['name'],$footerItem['Menu']['link']);?></h4>
	<div class="footerBottomLeftItemLinks">
		<?php if(isset($footerItem['Related'])){?>
		<?php foreach($footerItem['Related'] as $footerInnerItem):?>
			<h5 class="footerBottomLeftItemLink"><?php echo $html->link($footerInnerItem['Menu']['name'],$footerInnerItem['Menu']['link']);?></h5>
		<?php endforeach;?>
		<?php }?>
		<?php if($currentPageData['Page']['lang']=="en" and isset($footerItem['Inner'])){?>
		<?php foreach($footerItem['Inner'] as $footerInnerItem):?>
			<h5 class="footerBottomLeftItemLink"><?php echo $html->link($footerInnerItem['name'],$footerInnerItem['link']);?></h5>
		<?php endforeach;?>
		<?php }?>
	</div>
</div>
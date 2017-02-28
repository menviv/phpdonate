<div class="right articleSmallItem"<?php if($counter==3) echo " style='margin-left:0;'";?>>
	<div class="articleSmallItemImage"><?php echo $html->image("uploads/box/".$boxItem['Box']['src']);?></div>
	<div class="articleSmallItemTitle"><?php echo $boxItem['Box']['name'];?></div>
	<div class="articleSmallItemText"><?php echo $boxItem['Box']['text'];?></div>
	<div class="articleSmallItemLink"><?php echo $html->link("קרא בהרחבה","/".$boxItem['Box']['link']);?></div>
</div>
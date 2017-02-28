<div class="mainItemsBoxRight">
	<div class="mainItemsBoxRightTitle"><?php echo $item['Mainitem']['title'];?></div>
	<div class="mainItemsBoxRightSep"></div>
	<div class="mainItemsBoxRightImage"><?php echo $html->image("uploads/mainitems/".$item['Mainitem']['src']);?></div>
	<div class="mainItemsBoxRightText"><?php echo $item['Mainitem']['text'];?></div>
	<div class="mainItemsBoxContinueLink"><?php echo $html->link("המשך","/".$item['Mainitem']['link']);?></div>
</div>
<div class="mainItemsBoxLeft">
	<div class="mainItemsBoxLeftText">
		<div class="mainItemsBoxLeftTextContent">
			<div class="right mainItemsBoxLeftImage"><?php echo $html->image("uploads/mainitems/".$item['Mainitem']['src']);?></div>
			<div class="mainItemsBoxLeftTextTitle"><?php echo $item['Mainitem']['title'];?></div>
			<?php echo $item['Mainitem']['text'];?>
		</div>
		<div class="mainItemsBoxContinueLink"><?php echo $html->link("המשך","/".$item['Mainitem']['link']);?></div>
	</div>
</div>
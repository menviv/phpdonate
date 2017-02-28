<div class="eventItem">
	<div class="right eventItemRight">
		<div class="eventItemDate">
			<div class="eventItemDateDay"><?php echo date("j",strtotime($item['Event']['dateEvent']));?></div>
			<div class="eventItemDateMonth"><?php echo $monthsNames[date("n",strtotime($item['Event']['dateEvent']))];?></div>
		</div>
		<div class="eventItemShare">
			<div class="right eventItemShareFacebook"></div>
			<div class="right eventItemShareTwitter"></div>
			<div class="both"></div>
		</div>
	</div>
	<div class="right eventItemContent">
		<div class="eventItemTitle"><a href="<?php echo $html->url("/".$item['Event']['link']);?>"><?php echo $item['Event']['name'];?></a></div>
		<div class="eventItemExcerpt"><?php echo $item['Event']['excerpt'];?></div>
		<div class="eventItemMore"><?php echo $html->link("קרא בהרחבה...","/".$item['Event']['link']);?></div>
	</div>
	<div class="left eventItemImage">
		<?php echo $html->image("uploads/events/".$item['Event']['image']);?>
	</div>
	<div class="both"></div>
</div>
<div class="eventItemSep"></div>
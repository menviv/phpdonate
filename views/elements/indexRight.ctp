<div id="indexRight" class="right">
	<?php echo $this->element("news");?>
	<div class="indexRightEvent"><?php echo $html->link("לוח אירועים","/events");?></div>
	<div class="indexRightSep"></div>
	<div class="indexRightNiftyBtn"><div class="niftyBtnQ"></div><?php echo $html->link("שאלות ותשובות","/faq");?></div>
	<div class="indexRightNiftyBtn indexRightNiftyBtnP"><div class="niftyBtnP"></div><?php echo $html->link("קו פתוח","/info/openline");?></div>
	<div class="indexRightNiftyBtn indexRightNiftyBtnContact"><div class="niftyBtnContact"></div><?php echo $html->link("צור קשר","/contact");?></div>
	<div class="indexRightSep"></div>
	<?php if(isset($surveyAnswer)){?>
		<div id="review">
			<div id="reviewTop">
				<div id="reviewTopTitle"><?php echo $survey['Survey']['name'];?></div>
				<div id="reviewTopQuestion"><?php echo $survey['Survey']['title'];?></div>
			</div>
			<div id="reviewInner"><?php echo $this->element("surveyresult");?></div>
		</div>
	<?php }else{?>
		<?php echo $this->element("review");?>
	<?php }?>
</div>
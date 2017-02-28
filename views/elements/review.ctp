<div id="review">
	<div id="reviewTop">
		<div id="reviewTopTitle"><?php echo $survey['Survey']['name'];?></div>
		<div id="reviewTopQuestion"><?php echo $survey['Survey']['title'];?></div>
	</div>
	<div id="reviewInner">
		<form action="<?php echo $html->url("/sendSurvey");?>" method="post" id="surveyFormData">
			<div class="reviewAnswer">
				<div class="right reviewAnswerRadio"><input type="radio" name="data[survey][key]" value="1" /></div>
				<div class="right reviewAnswerText"><?php echo $survey['Survey']['answer1'];?></div>
				<div class="both"></div>
			</div>
			<div class="reviewAnswer">
				<div class="right reviewAnswerRadio"><input type="radio" name="data[survey][key]" value="2" /></div>
				<div class="right reviewAnswerText"><?php echo $survey['Survey']['answer2'];?></div>
				<div class="both"></div>
			</div>
			<div class="reviewAnswer">
				<div class="right reviewAnswerRadio"><input type="radio" name="data[survey][key]" value="3" /></div>
				<div class="right reviewAnswerText"><?php echo $survey['Survey']['answer3'];?></div>
				<div class="both"></div>
			</div>
			<div class="reviewAnswer">
				<div class="right reviewAnswerRadio"><input type="radio" name="data[survey][key]" value="4" /></div>
				<div class="right reviewAnswerText"><?php echo $survey['Survey']['answer4'];?></div>
				<div class="both"></div>
			</div>
			<div class="left reviewSubmit"><?php echo $form->submit("שלח");?></div>
			<div class="both"></div>
		</form>
	</div>
</div>
<script type="text/javascript">
	Event.observe('surveyFormData','submit',sendSurvey);
</script>
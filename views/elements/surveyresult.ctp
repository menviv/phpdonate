<div id="reviewResults">
	<?php for($i=0;$i<4;$i++){?>
		<?php $flag="answer".($i+1);?>
		<?php if(!empty($survey['Survey'][$flag])){?>
			<?php $width=1.13*$answers[$i+1];?>
			<div class="reviewResultRow">
				<div class="reviewResultRowName"><?php echo $survey['Survey'][$flag];?></div>
				<div class="reviewResultRowResult">
					<div class="right reviewResultRowResultInner">
						<div>
							<?php if($answers[$i+1]>0){?>
								<div class="right reviewResultRowResultInnerRight"></div>
								<?php if($answers[$i+1]>2){?>
									<div class="right reviewResultRowResultInnerCenter" style="width:<?php echo $width;?>px;"></div>
								<?php }?>
								<div class="right reviewResultRowResultInnerLeft"></div>
								<div class="both"></div>
							<?php }?>
						</div>
					</div>
					<div class="right reviewResultRowResultInnerText"><?php echo $answers[$i+1];?>%</div>
					<div class="both"></div>
				</div>
			</div>
		<?php }?>
	<?php }?>
	<?php if(1==2){?><div class="reviewResultRow">
		<div class="reviewResultRowName">משחקים ואמנות מתן פטרונות,<br />אחרונים למדי.</div>
		<div class="reviewResultRowResult">
			<div class="right reviewResultRowResultInner">
				<div>
					<div class="right reviewResultRowResultInnerRight"></div>
					<div class="right reviewResultRowResultInnerCenter" style="width:50px;"></div>
					<div class="right reviewResultRowResultInnerLeft"></div>
					<div class="both"></div>
				</div>
			</div>
			<div class="right reviewResultRowResultInnerText">15%</div>
			<div class="both"></div>
		</div>
	</div>
	<div class="reviewResultRow">
		<div class="reviewResultRowName">משחקים ואמנות מתן פטרונות,<br />אחרונים למדי.</div>
		<div class="reviewResultRowResult">
			<div class="right reviewResultRowResultInner"></div>
			<div class="right reviewResultRowResultInnerText">15%</div>
			<div class="both"></div>
		</div>
	</div>
	<div class="reviewResultRow">
		<div class="reviewResultRowName">משחקים ואמנות מתן פטרונות,<br />אחרונים למדי.</div>
		<div class="reviewResultRowResult">
			<div class="right reviewResultRowResultInner"></div>
			<div class="right reviewResultRowResultInnerText">15%</div>
			<div class="both"></div>
		</div>
	</div>
	<div class="reviewResultRow">
		<div class="reviewResultRowName">משחקים ואמנות מתן פטרונות,<br />אחרונים למדי.</div>
		<div class="reviewResultRowResult">
			<div class="right reviewResultRowResultInner"></div>
			<div class="right reviewResultRowResultInnerText">15%</div>
			<div class="both"></div>
		</div>
	</div>
	<?php }?>
</div>
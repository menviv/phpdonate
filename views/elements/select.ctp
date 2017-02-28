<div class="selectContainer">
	<div class="selectSel"><?php echo $selectFirstValue;?></div>
	<div class="selectOpen">
		<input type="hidden" name="<?php echo $selectNameHidden;?>" <?php if(isset($firstValue)) echo "value='$firstValue'";?> />
		<div class="selectInner">
			<?php foreach($selects as $key=>$value):?>
				<div class="selectInnerRow" id="<?php echo "selectInnerRow".$key;?>"><?php echo $value;?></div>
			<?php endforeach;?>
		</div>
		<div class="selectBottom"></div>
	</div>
</div>
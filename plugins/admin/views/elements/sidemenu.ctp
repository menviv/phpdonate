<div id="sidemenutoptitle"></div>
<div id="sidemenu">
	<?php $counter=1;?>
	<?php foreach ($aditionalmenu as $menuitem):?>
		<div class="sidemenutitle" id="sidemenutitle<?php echo $counter;?>">
			<div class="sidemenuicon left">
				<?php if(isset($menuitem['icon'])) echo $html->image("/admin/img/icons/".$menuitem['icon']);?>
			</div>
			<div class="sidemenutitletext left"><?php echo $html->link($menuitem['name'],$menuitem['link']);?></div>
			<div class="both"></div>
		</div>
		<?php $counter++;?>
	<?php endforeach;?>
</div>
<div id="breadCrumbs">
	<?php $counter = 1;?>
	<?php foreach ($breadcrumbs as $breadcrumb):?>
		<?php if($this->params['url']['url']==$breadcrumb['link'] or ($this->params['action']=="index" and $breadcrumb['link']=="")){?>
			<div class="right breadCrumb"><?php echo $breadcrumb['name'];?></div>
		<?php }else{?>
			<div class="right breadCrumb"><?php echo $html->link($breadcrumb['name'],"/".$breadcrumb['link']);?></div>
		<?php }?>
		<?php if(sizeof($breadcrumbs)>$counter){?>
			<div class="right breadCrumbArrow"></div>
		<?php }?>
		<?php $counter++;?>
	<?php endforeach;?>
	<div class="both"></div>
</div>
<div id="news">
	<div id="newsTitle"><?php echo $html->link("חדשות","/news");?></div>
	<?php $counter = 0;?>
	<?php foreach($news as $newsItem):?>
		<?php echo $this->element("newsItem",array("newsItem"=>$newsItem));?>
		<?php if($counter<=sizeof($newsItem)){?>
			<div class="newsItemSep"></div>
		<?php }?>
		<?php $counter++;?>
	<?php endforeach;?>
</div>
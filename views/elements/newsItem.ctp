<?php
$findme   = 'http://';
$pos = strpos($newsItem['News']['link'], $findme);
if($pos === false){
	$newsItem['News']['link'] = "/".$newsItem['News']['link'];
}
?>
<div class="newsItem">
	<div class="newsItemTitle"><?php echo $html->link($newsItem['News']['name'],$newsItem['News']['link']);?></div>
	<div class="newsItemText"><?php echo $html->link($newsItem['News']['text'],$newsItem['News']['link']);?></div>
</div>
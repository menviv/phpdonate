<?php
$readMore = "קרא בהרחבה...";
if($currentPageData['Page']['lang']=="en"){
	$readMore = "Read More...";
}
?>

<div class="right mainarticlePageThumb">
	<?php if(empty($item['Portalitem']['src'])){?>
		<div class="mainarticlePageThumbImage"><?php echo $html->image("layout/portalimage.jpg");?></div>
	<?php }else{?>
		<div class="mainarticlePageThumbImage"><?php echo $html->image("uploads/portal/".$item['Portalitem']['src']);?></div>
	<?php }?>
	
	<div class="mainarticlePageThumbOver"></div>
	<div class="mainarticlePageThumbTitle"><?php echo $item['Portalitem']['name'];?></div>
	<div class="mainarticlePageThumbText"><?php echo $item['Portalitem']['summary'];?></div>
	<div class="mainarticlePageThumbLink"><?php echo $html->link($readMore,"/".$item['Portalitem']['link']);?></div>
</div>
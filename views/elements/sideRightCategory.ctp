<?php 
	if($category['Menu']['link']=="/" and !empty($category['Inner'])){
		$category['Menu']['link'] = $category['Inner'][0]['link'];
	}
?>
<div class="sideRightCategory">
	<div class="sideRightCategoryTitle<?php if($menuParentId==$category['Menu']['id'] or $category['Menu']['link']=="/".$currentPageData['Page']['link']) echo " sideRightCategoryTitleSel";?>"><h2><?php echo $html->link($category['Menu']['name'],$category['Menu']['link']);?></h2></div>
	<div class="both"></div>
	<div class="sideRightCategoryInner"<?php if(($menuParentId!=$category['Menu']['id'] and $category['Menu']['id']!=$menuParentIdAll['id']) or $category['Menu']['link']=="/news") echo ' style="display:none;"';?>>
		<?php foreach($category['Inner'] as $innerCat):?>
			<div class="sideRightCategorySubtitle<?php if("/".$this->params['url']['url']==$innerCat['link']) echo " sideRightCategorySubtitleSel";?>"><h3><?php echo $html->link($innerCat['name'],$innerCat['link']);?></h3></div>
		<?php endforeach;?>
	</div>
</div>
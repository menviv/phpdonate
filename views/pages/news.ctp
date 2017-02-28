<?php echo $this->element("sideRight");?>
<div id="newsPage" class="leftSideSmall right">
	<?php echo $this->element("breadcrumbs");?>
	<div id="articlePageTop">
		<div id="articlePageTopImage"><?php echo $html->image("uploads/news.png");?></div>
		<div id="articlePageTopTitle" class="topWidth"><?php echo $currentPageData['Page']['pname'];?></div>
		<div id="articlePageTopText" class="topWidth"><?php echo $currentPageData['Page']['content'];?></div>
	</div>
	<div id="newsPageItems">
		<?php foreach($news as $newsItem):?>
			<?php
			$findme   = 'http://';
			$pos = strpos($newsItem['News']['link'], $findme);
			if($pos === false){
				$newsItem['News']['link'] = "/".$newsItem['News']['link'];
			}
			?>
			<div class="newsPageItem">
				<div class="right newsPageItemIcon"></div>
				<div class="right newsPageItemContent">
					<div class="newsPageItemTitle"><?php echo $html->link($newsItem['News']['name'],$newsItem['News']['link']);?></div>
					<div class="newsPageItemSummary"><?php echo $html->link($newsItem['News']['text'],$newsItem['News']['link']);?></div>
					<div class="newsPageItemDate"><?php echo date("d.m.Y",strtotime($newsItem['News']['dateAdd']));?></div>
				</div>
				<div class="both"></div>
			</div>
		<?php endforeach;?>
	</div>
	<div id="newsPagePaginate">
		<?php echo $this->element("paginate");?>
	</div>
</div>
<div class="both"></div>
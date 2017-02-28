<?php echo $this->element("sideRight");?>
<div id="searchPage" class="leftSideSmall right">
	<div id="articlePageTop">
		<div id="articlePageTopImage"><?php echo $html->image("uploads/search.png");?></div>
		<div id="articlePageTopTitle" class="topWidth"><?php echo $currentPageData['Page']['pname'];?></div>
		<div id="articlePageTopText" class="topWidth" style="margin-top:10px;">נמצאו <?php echo $count;?> תוצאות לערך "<?php echo $searchText;?>"</div>
	</div>
	<div id="searchPageItems">
		<?php foreach($result as $resultItem):?>
			<div class="newsPageItem">
				<div class="newsPageItemContent">
					<div class="newsPageItemTitle"><?php echo $html->link($resultItem['Page']['pname'],"/".$resultItem['Page']['link']);?></div>
					<div class="newsPageItemSummary"><?php echo iconv("Windows-1255","UTF-8", $this->maxchars(iconv("UTF-8", "Windows-1255",strip_tags($resultItem['Page']['content'])),200));?></div>
					<?php if(1==2){?><div class="newsPageItemDate"><?php echo date("d.m.Y",strtotime($resultItem['Page']['dateAdd']));?></div><?php }?>
				</div>
			</div>
		<?php endforeach;?>
	</div>
	<div id="newsPagePaginate">
		<?php echo $this->element("paginate");?>
	</div>
</div>
<div class="both"></div>
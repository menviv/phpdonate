<?php echo $this->element("sideRight");?>
<div id="galleryinnerPage" class="leftSideSmall right">
	<?php echo $this->element("breadcrumbs");?>
	<div id="mainarticlePageTopTitle"><?php echo $currentPageData['Page']['pname'];?></div>
	<div id="pageShareLinks">
		<?php echo $this->element("shareRow");?>
		<div class="both"></div>
	</div>
	<div class="pageShareLinksSep"></div>
	<div id="galleryinnerPageThumbs">
		<div class="galleryinnerPageThumbsBack left"><a href="<?php echo $html->url($mainGallLink);?>">חזרה לרשימת הגלריות</a></div>
		<div class="both"></div>
		<div id="galleryinnerPageThumbsInner">
			<?php $counter = 1;?>
			<?php foreach($images as $item):?>
				<?php echo $this->element("galleryInnerItem",array("counter"=>$counter,"item"=>$item));?>
				<?php $counter++;?>
			<?php endforeach?>
			<div class="both"></div>
		</div>
		<div id="galleryinnerPagePaginate">
			<?php echo $this->element("paginate");?>
		</div>
		<div class="galleryinnerPageThumbsBack"><a href="<?php echo $html->url($mainGallLink);?>">חזרה לרשימת הגלריות</a></div>
	</div>
</div>
<div class="both"></div>
<style type="text/css">
#galleryinnerPageThumbs{margin:13px 14px 0 0;width:652px;}
.galleryinnerPageThumbsBack a{display:block;height:13px;color:#0282cb;font-size:11px;font-weight:bold;text-decoration:none;padding-right:20px;background:url('img/layout/gallerymovieicon.jpg') no-repeat right top;}
#galleryinnerPageThumbsInner{margin-top:20px;}
.galleryinnerPageItem{width:151px;height:131px;margin:0 0 10px 15px;}
.galleryinnerPageItem .galleryItemHref{border:4px solid #dcdcdc;width:143px;height:105px;display:block;text-align:center;}
.galleryinnerPageItem .galleryItemHref table{width:143px;}
.galleryinnerPageItem .galleryItemHref:hover{border:4px solid #a9d3eb;}
.galleryinnerPageItem span{display:block;}
#galleryinnerPagePaginate{margin:10px 0 15px;}
#galleryinnerPagePaginate table{margin:0 auto;}
.galleryinnerPageItemBtns{margin-top:2px;height:16px;line-height:16px;}
.galleryinnerPageItemShare a{font-size:11px;color:#0282CB;text-decoration:none;}
.galleryinnerPageItemTitle{color:#636363;font-size:11px;}
.outer{height:105px;overflow:hidden;position:relative;}
.outer[id] {display:table;position:static;}

.middle {position:absolute;top:50%;right:0;} /* for explorer only*/
.middle[id] {display:table-cell;vertical-align:middle;width:100%;}

.inner {position:relative;top:-50%;right:0;} /* for explorer only */
/* optional: #inner[id] {position: static;} */
</style>
<script type="text/javascript">
function startGallery(){
	$j("a[rel=group]").fancybox({
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'titlePosition' 	: 'over',
		'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
			return '<span id="fancybox-title-over">תמונה ' + currentArray.length + ' / ' + (currentIndex + 1) + (title.length ? ' &nbsp; ' + title : '') + '</span>';
		}
	});
}
startGallery();
</script>
<?php $monthsInserted = array();?>
<?php $monthsNames = array(1=>"ינואר",2=>"פברואר",3=>"מרץ",4=>"אפריל",5=>"מאי",6=>"יוני",7=>"יולי",8=>"אוגוסט",9=>"ספטמבר",10=>"אוקטובר",11=>"נובמבר",12=>"דצמבר");?>
<?php echo $this->element("sideRight");?>
<div id="eventPage" class="leftSideSmall right">
	<?php echo $this->element("breadcrumbs");?>
	<div id="articlePageTop">
		<div id="articlePageTopImage"><?php echo $html->image("uploads/events.png");?></div>
		<div id="articlePageTopTitle" class="topWidth"><?php echo $currentPageData['Page']['pname'];?></div>
		<div id="articlePageTopText" class="topWidth"><?php echo $event['Event']['excerpt'];?></div>
	</div>
	<div id="pageShareLinks">
		<?php echo $this->element("shareRow");?>
		<div class="both"></div>
	</div>
	<div class="pageShareLinksSep"></div>
	<div id="eventsContainer">
		<div class="eventsBackToAll">
			<div class="eventsBackToAllLink left"><?php echo $html->link("חזרה לרשימת האירועים","/".$eventsLink);?></div>
			<div class="both"></div>
		</div>
		<div id="eventInner">
			<div id="eventInnerTitle"><?php echo $event['Event']['innertitle'];?></div>
			<div id="eventInnerTop">
				<div class="right eventItemRight">
					<div class="eventItemDate">
						<div class="eventItemDateDay"><?php echo date("j",strtotime($event['Event']['dateEvent']));?></div>
						<div class="eventItemDateMonth"><?php echo $monthsNames[date("n",strtotime($event['Event']['dateEvent']))];?></div>
					</div>
					<div class="eventItemShare">
						<div class="right eventItemShareFacebook"></div>
						<div class="right eventItemShareTwitter"></div>
						<div class="both"></div>
					</div>
				</div>
				<div id="eventInnerTopContent" class="right">
					<div id="eventInnerTopTitle"><?php echo $event['Event']['name'];?></div>
					<div id="eventInnerText"><?php echo $event['Event']['text'];?></div>
				</div>
				<div class="both"></div>
			</div>
			<?php if(sizeof($galleryImages)>1){?>
			<div class="eventItemSep"></div>
			<div id="eventInnerGallery">
				<div id="galleryBigImage">	
					<?php if(sizeof($galleryImages)>1){?><div id="galleryBigImageHere"><?php echo $html->image("uploads/gallery/".$galleryImages[0]['Gallery']['src']);?></div><?php }?>
				</div>
				<?php if(sizeof($galleryImages)>1){?>
					<div id="eventInnerGalleryThumbs">
						<div class="arrowRight" id="arrowRightActive"><div id="arrowRightActiveInner" style="display:none;"><a href="javascript:void(0);" onclick="gallerySlide('right')"><?php echo $html->image("layout/arrowright.png");?></a></div></div>
						<div class="arrowLeft" id="arrowLeftActive"><div id="arrowLeftActiveInner"<?php if(sizeof($galleryImages)<5) echo " style='display:none;'";?>><a href="javascript:void(0);" onclick="gallerySlide('left')"><?php echo $html->image("layout/arrowleft.png");?></a></div></div>
						<div id="eventInnerGalleryThumbsContainer">
							<div id="eventInnerGalleryThumbsInner" style="width:<?php echo 103*sizeof($galleryImages);?>px;">
								<?php $counter = 0;?>
								<?php foreach ($galleryImages as $galleryImage):?>
									<div class="right eventGalleryThumb" id="eventGalleryThumb<?php echo $counter;?>">
										<div class="eventGalleryThumbInner"><a href="javascript:void(0);" onclick="changeImage('<?php echo $counter;?>')"><?php echo $html->image("uploads/gallery/".$galleryImage['Gallery']['thumb']);?></a></div>
									</div>
									<?php $counter++;?>
								<?php endforeach;?>
								<div class="both"></div>
							</div>
						</div>
					</div>
				<?php }?>
			</div>
			<?php }?>
			<div class="eventsBackToAll">
				<div class="eventsBackToAllLink right"><?php echo $html->link("חזרה לרשימת האירועים","/".$eventsLink);?></div>
				<div class="both"></div>
			</div>
		</div>
	</div>
</div>
<div class="both"></div>
<script type="text/javascript">
	canMove = true;
	currentPage = 1;
	maxImages = <?php echo ceil(sizeof($galleryImages)/4);?>;
	galleryImages = <?php echo json_encode($galleryImages);?>;
</script>
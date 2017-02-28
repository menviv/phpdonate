<?php echo $this->element("sideRight");?>
<div id="faqPage" class="leftSideSmall right">
	<?php echo $this->element("breadcrumbs");?>
	<div id="articlePageTop">
		<div id="articlePageTopImage"><?php echo $html->image("uploads/drugs.png");?></div>
		<div id="articlePageTopTitle" class="topWidth"><?php echo $currentPageData['Page']['pname'];?></div>
		<div id="articlePageTopText" class="topWidth"><?php echo $currentPageData['Page']['content'];?></div>
	</div>
	<div id="faqQuestionsContainer" class="drugsContainer">
		<?php foreach($drugs as $drug):?>
			<div class="questionRow<?php if(isset($drugFound) and $drugFound['Drug']['parent']==$drug['Drug']['id']) echo " drugRowSel";?>">
				<div class="questionRowTop">
					<div class="right questionRowTitle"><a href="javascript:void(0);" onclick="openDrug(this)"><?php echo $drug['Drug']['name'];?></a></div>
					<div class="left questionRowOpen"><a href="javascript:void(0);" onclick="openDrug(this)">הצג הכל</a></div>
					<div class="both"></div>
				</div>
				<div class="questionRowAnswerContainer">
					<?php foreach($drug['Inner'] as $inner):?>
						<div class="drugInnerRow">
							<a name="<?php echo $inner['id'];?>"></a>
							<div class="right drugInnerRowSrc"><?php echo $html->image("uploads/drugs/".$inner['src']);?></div>
							<div class="right drugInnerRowTexts<?php if(isset($drugFound) and $drugFound['Drug']['id']==$inner['id']) echo " drugInnerRowTextsSel";?>">
								<div class="drugInnerRowTextsTitle"><a href="javascript:void(0);" onclick="openDrugInner(this)"><?php echo $inner['name'];?></a></div>
								<div class="drugInnerRowTextsText"><?php echo $inner['text'];?></div>
							</div>
							<div class="both"></div>
						</div>
						<div class="questionRowSep"></div>
					<?php endforeach;?>
				</div>
			</div>
		<?php endforeach;?>
	</div>
</div>
<div class="both"></div>
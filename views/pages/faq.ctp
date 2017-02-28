<?php 
$openText['he'] = array("openall"=>"הצג הכל","open"=>"הצג","close"=>"סגור","closeall"=>"סגור הכל");
$openText['en'] = array("openall"=>"Open all","open"=>"Open","close"=>"Close","closeall"=>"Close all");
?>
<?php echo $this->element("sideRight");?>
<div id="faqPage" class="leftSideSmall right">
	<?php echo $this->element("breadcrumbs");?>
	<div id="articlePageTop">
		<div id="articlePageTopImage"><?php echo $html->image("uploads/faq.png");?></div>
		<div id="articlePageTopTitle" class="topWidth"><?php echo $currentPageData['Page']['pname'];?></div>
		<div id="articlePageTopText" class="topWidth"><?php echo $currentPageData['Page']['content'];?></div>
	</div>
	<div id="faqQuestionsContainer">
		<?php foreach($questions as $question):?>
			<div class="questionRow">
				<div class="questionRowTop">
					<div class="right questionRowTitle"><a href="javascript:void(0);" onclick="openFaq(this)"><?php echo $question['Question']['name'];?></a></div>
					<div class="left questionRowOpen"><a href="javascript:void(0);" onclick="openFaq(this)"><?php echo $openText[$currentPageData['Page']['lang']]['openall'];?></a></div>
					<div class="both"></div>
				</div>
				<div class="questionRowAnswerContainer">
					<?php foreach($question['Answer'] as $answer):?>
						<div class="questionRowAnswer">
							<div class="questionRowAnswerTop">
								<div class="right questionRowAnswerTitle"><a href="javascript:void(0);" onclick="openFaqItem(this)"><?php echo $answer['name'];?></a></div>
								<div class="left questionRowAnswerOpen"><a class="faqAnswerRowOpen" href="javascript:void(0);" onclick="openFaqItem(this)"><?php echo $openText[$currentPageData['Page']['lang']]['open'];?></a><a class="faqAnswerRowClose" style="display:none;" href="javascript:void(0);" onclick="openFaqItem(this)"><?php echo $openText[$currentPageData['Page']['lang']]['close'];?></a></div>
								<div class="both"></div>
							</div>
							<div class="questionRowAnswerContent" style="display:none"><?php echo $answer['text'];?></div>
						</div>
					<?php endforeach;?>
				</div>
			</div>
			<div class="questionRowSep"></div>
		<?php endforeach;?>
	</div>
</div>
<div class="both"></div>
<script type="text/javascript">
openAll = "<?php echo $openText[$currentPageData['Page']['lang']]['openall'];?>";
closeAll = "<?php echo $openText[$currentPageData['Page']['lang']]['closeall'];?>";
</script>
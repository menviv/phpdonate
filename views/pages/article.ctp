<?php 
$monthsNames['he'] = array(1=>"ינואר",2=>"פברואר",3=>"מרץ",4=>"אפריל",5=>"מאי",6=>"יוני",7=>"יולי",8=>"אוגוסט",9=>"ספטמבר",10=>"אוקטובר",11=>"נובמבר",12=>"דצמבר");
$monthsNames['en'] = array(1=>"January",2=>"February",3=>"March",4=>"April",5=>"May",6=>"June",7=>"July",8=>"August",9=>"September",10=>"October",11=>"November",12=>"December");
$author['he'] = "מאת";
$author['en'] = "Author";
?>
<?php 
	$month = date("m",strtotime($article['Article']['date_of_article']));
	if($month<10){
		$month = str_replace("0","",$month);
	}
	$month = $monthsNames[$currentPageData['Page']['lang']][$month];
	$year = date("Y",strtotime($article['Article']['date_of_article']));
	$articleDate = $month." ".$year;
	if(empty($article['Article']['date_of_article']))
		$articleDate = "";
?>
<?php echo $this->element("sideRight");?>
<div id="articlePage" class="leftSideSmall right">
	<?php echo $this->element("breadcrumbs");?>
	<div id="articlePageTop">
		<div id="articlePageTopImage"><?php echo $html->image("layout/top".$currentPageData['Page']['parent'].".png");?></div>
		<div id="articlePageTopTitle" class="topWidth"><?php echo $article['Article']['title'];?></div>
		<div id="articlePageTopText" class="topWidth"><?php echo strip_tags($article['Article']['description']);?></div>
	</div>
	<div id="pageShareLinks">
		<?php echo $this->element("shareRow");?>
		<div class="both"></div>
	</div>
	<div class="pageShareLinksSep"></div>
	<div id="articlePageInner">
		<div id="articlePageAuthor"><?php if(!empty($article['Article']['author'])) echo $author[$currentPageData['Page']['lang']].": ".$article['Article']['author']." // ";?><?php echo $articleDate;?></div>
		<div id="articlePageText"><?php echo $this->replaceItem($article['Article']['content']);?></div>
	</div>
</div>
<div class="both"></div>
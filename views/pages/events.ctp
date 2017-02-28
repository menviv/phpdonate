<?php $monthsInserted = array();?>
<?php $monthsNames = array(1=>"ינואר",2=>"פברואר",3=>"מרץ",4=>"אפריל",5=>"מאי",6=>"יוני",7=>"יולי",8=>"אוגוסט",9=>"ספטמבר",10=>"אוקטובר",11=>"נובמבר",12=>"דצמבר");?>
<?php echo $this->element("sideRight");?>
<div id="eventsPage" class="leftSideSmall right">
	<?php echo $this->element("breadcrumbs");?>
	<div id="articlePageTop">
		<div id="articlePageTopImage"><?php echo $html->image("uploads/events.png");?></div>
		<div id="articlePageTopTitle" class="topWidth"><?php echo $currentPageData['Page']['pname'];?></div>
		<div id="articlePageTopText" class="topWidth"><?php echo $currentPageData['Page']['content'];?></div>
	</div>
	<div id="pageShareLinks">
		<?php echo $this->element("shareRow");?>
		<div class="both"></div>
	</div>
	<div class="pageShareLinksSep"></div>
	<div id="eventsContainer">
		<div id="eventsArchive">
			<div id="eventsArchiveLink" class="left">
				<?php 
					if(isset($archive))
						echo $html->link("חזרה לרשימת האירועים","/".$currentPageData['Page']['link']);
					else
						echo $html->link("ארכיון אירועים","/".$currentPageData['Page']['link']."?archive=true");
				?>
			</div>
			<div class="both"></div>
		</div>
		<?php 
		foreach($events as $event):
			$year = date("Y",strtotime($event['Event']['dateEvent']));
			$month = date("n",strtotime($event['Event']['dateEvent']));
			if(!isset($monthsInserted[$year]) or !isset($monthsInserted[$year][$month])){
				echo $this->element("eventsMonth",array("month"=>$month,"year"=>$year,"monthsNames"=>$monthsNames));
				$monthsInserted[$year][$month] = true;
			}
			echo $this->element("event",array("item"=>$event,"monthsNames"=>$monthsNames));
		endforeach;
		?>
	</div>
</div>
<div class="both"></div>
<script type="text/javascript">
	$$('div.eventItemContent').invoke('observe', 'click', changeLinkLocation);
</script>
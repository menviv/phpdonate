<?php 
$logo = "logo.png";
$search = "חיפוש";
$homeUrl = "";
if($currentPageData['Page']['lang']=="en"){
	$logo = "logoen.png";
	$search = "Search";
	$homeUrl = "en";
}
?>
<div id="logo"><a href="<?php echo $html->url("/".$homeUrl);?>"><?php echo $html->image("layout/".$logo,array("title"=>"הוועד למלחמה באיידס"));?></a></div>
<div id="facebookHeader"><a href="http://www.facebook.com/pages/hwwd-lmlhmh-byyds/180945648986" target="_blank"><?php echo $html->image("transparent.gif",array("title"=>"Facebook","alt"=>"Facebook"));?></a></div>
<div id="donation"><a href="<?php 
	if($currentPageData['Page']['lang']=="en"){
		echo $html->url("/en/donate");
	} else{
		echo $html->url("/donate");
	}?>"><?php echo $html->image("transparent.gif",array("title"=>"תרומות"));?></a></div>
<div id="search">
	<form action="<?php echo $html->url("/search");?>" method="get">
		<div class="searchInput right"><?php echo $form->input("search.text",array("div"=>false,"label"=>false,"name"=>"search","value"=>$search,"onfocus"=>"if(this.value=='".$search."')this.value=''","onblur"=>"if(this.value=='')this.value='".$search."'"));?></div>
		<div class="searchSubmit right"><?php echo $form->submit("");?></div>
		<div class="both"></div>
	</form>
</div>
<?php if($currentPageData['Page']['lang']!="en"){?>
<div id="headerLinks">
	<?php $counter = 1;?>
	<?php $firstActive = false;?>
	<?php foreach($headerLinks as $headerLink):?>
		<?php 
			$addClass = "";
			if($counter==$headerConnected or ("/".$this->params['url']['url']==$headerLink['Menu']['link'])){
				if($counter==1)
					$firstActive = true;
				$addClass = " headerLinkSelShow";
				$headerConnected = $counter;
			}
		?>
		<div class="right headerLink headerLink<?php echo $counter;?><?php echo $addClass;?>"<?php if($counter==5) echo " style='width:138px;'";?> style="position:relative;">
			<div class="headerLinkSel headerLinkSel<?php echo $counter;?>"></div>
			<div class="headerBack" style="position:absolute;top:33px;right:0"><?php echo $html->image("layout/tabs/tab".$counter.".png");?></div>
			<h1><?php echo $html->link($headerLink['Menu']['name'],$headerLink['Menu']['link']);?></h1>
		</div>
		<?php $counter++;?>
	<?php endforeach;?>
	<div class="both"></div>
</div>
<?php }?>

<div id="headerLangs"<?php if($firstActive) echo " class='off'";?>>
	<div class="right headerLang<?php if($currentPageData['Page']['lang']=="en") echo " active";?>"><a href="<?php echo $html->url("/en");?>">EN</a></div>
	<div class="right headerLang<?php if($currentPageData['Page']['lang']!="en") echo " active";?>"><a href="<?php echo $html->url("/");?>">HE</a></div>
	<div class="both"></div>
</div>
<script type="text/javascript">
	$j("div.headerLink h1").hover(function(){
		ele = $(this.parentNode).select(".headerBack")[0];
		$j("#headerLangs").addClass("off");
		$j(ele).addClass("hover").stop().animate({
				top:'-90px'
			}, 200, function(){
				$j(ele).animate({
					top:'-80px'
					},200, function() {
						
				})});	
		} ,function() {
		$j((ele)).removeClass("hover").stop()  /* Remove the "hover" class , then stop animation queue buildup*/
			.animate({
				top:'33px'
			}, 200,function(){$j("#headerLangs").removeClass("off");});
	});
</script>
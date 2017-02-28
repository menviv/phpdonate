<?php
$links = $headerLinks;
$top = "לראש הדף";
if($currentPageData['Page']['lang']=="en"){
	$links = $footerLinks;
	$top = "Top";
}
?>
<div class="footerBottomLeftItem" id="footerAddress">
	<h4 class="footerBottomLeftItemTitle">הכתובת שלנו</h4>
	<div class="footerBottomLeftItemLinks">
		<h5 class="footerBottomLeftItemLink">הוועד למלחמה באיידס <br />רחוב הנצי"ב 18, ת"א.<br />מיקוד 6157301  <br />ת.ד. 57310, ת"א.</h5>
	</div>
</div>
<div id="footerTop">
	<div id="footerToTopArrow"><a href="#top"><?php echo $html->image("layout/toparrow.png");?></a></div>
	<div id="footerTopLeft">
		<?php echo $this->element("shareRow");?>
		<div class="left" id="footerTopLeftToTopLink"><a href="#top"><?php echo $top;?></a></div>
		<div class="both"></div>
	</div>
</div>
<div id="footerBottom">
	<div id="footerBottomLeft">
		<?php foreach($links as $footerItem):?>
			<?php echo $this->element("footerLeftItem",array("footerItem"=>$footerItem));?>
		<?php endforeach;?>
		<div class="both"></div>
	</div>
	<div class="footerBottomSep"></div>
	<div id="footerBottomRight">
		<div id="footerBottomRightRound" class="footerBottomRightItem right">
			<div class="footerBottomRightImage" style="margin-top:12px;height:80px;"><a href="http://www.round-up.org.il/%D7%94%D7%95%D7%95%D7%A2%D7%93-%D7%9C%D7%9E%D7%9C%D7%97%D7%9E%D7%94-%D7%91%D7%90%D7%99%D7%99%D7%93%D7%A1" target="_blank"><?php echo $html->image("layout/roundup.jpg",array("width"=>"85"));?></a></div>
			<div class="footerBottomRightText"><a href="http://www.round-up.org.il/?categoryId=37781&itemId=69976" target="_blank">עגל לטובת <br />“הוועד למלחמה באיידס”</a></div>
		</div>
		<div id="footerBottomRightIsrael" class="footerBottomRightItem right">
			<div class="footerBottomRightImage" style="height:99px;"><a href="http://www.hivtalk.com/" target="_blank"><?php echo $html->image("layout/hivtalk.jpg");?></a></div>
			<div class="both"></div>
		</div>
		<div id="footerBottomRightIsrael" class="footerBottomRightItem right">
			<div class="footerBottomRightImage" style="height:123px;"><a href="http://www.midot.org.il/%D7%94%D7%95%D7%95%D7%A2%D7%93-%D7%9C%D7%9E%D7%9C%D7%97%D7%9E%D7%94-%D7%91%D7%90%D7%99%D7%99%D7%93%D7%A1" target="_blank"><?php echo $html->image("layout/tav.jpg");?></a></div>
			<div class="both"></div>
		</div>
		<div class="both"></div>
	</div>
</div>
<div id="footerCopyrights">
	<div class="right" id="vaadLogo"><?php echo $html->image("layout/vaad.jpg");?></div>
	<div class="right"><a href="http://aidsisrael.org.il/takanon">תקנון</a></div>
	<div class="right footerCopyrightsSep">|</div>
	<div class="right">כל הזכויות שמורות לוועד למלחמה באיידס ©   2010</div>
	<div class="right footerCopyrightsSep">|</div>
	<div class="right" id="footerCopyrightBears">קונספט ועיצוב: <a href="http://www.3bears.co.il" target="_blank">שלושת הדובים</a></div>
	<div class="right footerCopyrightsSep">|</div>
	<div class="right" id="footerCopyrightQuatro"><a href="http://www.quatro-digital.com" target="_blank">בניית אתרים</a>: <a href="http://www.quatro-digital.com" target="_blank" class="quatroLink">Quatro Digital</a></div>
	<div class="both"></div>
</div>
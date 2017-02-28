<?php 
$shareText['he'] = array("sharefriends"=>"שתף עם חברים","print"=>"הדפס","mail"=>"שלח למייל","facebook"=>"שתף ב-Facebook","twitter"=>"שתף ב-twitter","contact"=>"צור קשר");
$shareText['en'] = array("sharefriends"=>"Share with friends","print"=>"Print","mail"=>"Mail","facebook"=>"Share on Facebook","twitter"=>"Share on Twitter","contact"=>"Contact");
?>
<?php if(1==2){?><div class="right pageShareLinkIcon"><?php echo $html->image("layout/rssicon.png");?></div>
<div class="right pageShareLinkText"><?php echo $html->link("RSS","/rss");?></div><?php }?>
<div class="right pageShareLinkIcon"><?php echo $html->image("layout/share.png");?></div>
<div class="right pageShareLinkText">
	<script type="text/javascript">var addthis_config ={ui_click: true}</script>
	<!-- AddThis Button BEGIN -->
	<div class="addthis_toolbox addthis_default_style"><a href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4c1f73c3451e7ef7" class="addthis_button_compact"><?php echo $shareText[$currentPageData['Page']['lang']]['sharefriends'];?></a></div>
	<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4c1f73c3451e7ef7"></script>
	<!-- AddThis Button END -->
</div>
<div class="right pageShareLinkIcon"><a href="javascript:void(0);" onclick="window.print();return false;"><?php echo $html->image("layout/print.png");?></a></div>
<div class="right pageShareLinkText"><a href="javascript:void(0);" onclick="window.print();return false;"><?php echo $shareText[$currentPageData['Page']['lang']]['print'];?></a></div>
<div class="right pageShareLinkIcon"><?php echo $html->image("layout/icon_mail.png");?></div>
<div class="right pageShareLinkText"><a href="javascript:void(0);" onclick="addthis_sendto('email');"><?php echo $shareText[$currentPageData['Page']['lang']]['mail'];?></a></div>
<div class="right pageShareLinkIcon"><a href="http://www.facebook.com/sharer.php?u=http://<?php echo $_SERVER['HTTP_HOST'].$html->url("/".$currentPageData['Page']['link']."?reffer=sharefaceb");?>" target="_blank"><?php echo $html->image("layout/facebook.png");?></a></div>
<div class="right pageShareLinkText"><a href="http://www.facebook.com/sharer.php?u=http://<?php echo $_SERVER['HTTP_HOST'].$html->url("/".$currentPageData['Page']['link']."?reffer=sharefaceb");?>" target="_blank"><?php echo $shareText[$currentPageData['Page']['lang']]['facebook'];?></a></div>
<div class="right pageShareLinkIcon"><a href="http://twitter.com/home?status= http://<?php echo $_SERVER['HTTP_HOST'].$html->url("/".$currentPageData['Page']['link']."?reffer=twitter");?>" target="_blank"><?php echo $html->image("layout/twitter.png");?></a></div>
<div class="right pageShareLinkText"><a href="http://twitter.com/home?status= http://<?php echo $_SERVER['HTTP_HOST'].$html->url("/".$currentPageData['Page']['link']."?reffer=twitter");?>" target="_blank"><?php echo $shareText[$currentPageData['Page']['lang']]['twitter'];?></a></div>
<div class="right pageShareLinkIcon"><a href="<?php echo $html->url("/contact");?>"><?php echo $html->image("layout/mail.png");?></a></div>
<div class="right pageShareLinkText"><?php echo $html->link($shareText[$currentPageData['Page']['lang']]['contact'],"/contact");?></div>

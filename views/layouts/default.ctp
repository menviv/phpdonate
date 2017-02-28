<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset('UTF-8');?>
	<title><?php if($currentPageData['Page']['id']!=1) echo " הוועד למלחמה באיידס -";?> <?php echo $title_for_layout;?></title>
	<meta name="google-site-verification" content="kXgJhP4kycEI-zXePuliG4n885JOMeWz0a1PlZJQHaQ" />
	<?php if(1==2){?>
		<link href="thumbnail_image" rel="http://www.aidsisrael.org.il/img/layout/chicken.jpg" />
		<meta property="og:image" content="http://www.aidsisrael.org.il/img/layout/chicken.jpg" />
	<?php }?>
	<meta property="og:image" content="http://www.aidsisrael.org.il/img/layout/logo_big.jpg" />
	<?php if($currentPageData['Page']['type']=="article"){?>
	<meta property="og:title" content="<?php echo $article['Article']['title'];?>" />
	<meta property="og:description" content="<?php echo strip_tags(str_replace('"',"",$article['Article']['description']));?>" />
	<?php }?>
	<?php if($currentPageData['Page']['type']=="event"){?>
	<meta property="og:title" content="<?php echo $currentPageData['Page']['pname'];?>" />
	<meta property="og:description" content="<?php echo strip_tags(str_replace('"',"",$event['Event']['excerpt']));?>" />
	<?php }?>
	<?php if(in_array($currentPageData['Page']['type'],array("mainitems","contact","donate","drugs","events","faq","news"))){?>
	<meta property="og:title" content="<?php echo $currentPageData['Page']['pname'];?>" />
	<meta property="og:description" content="<?php echo strip_tags(str_replace('"',"",$currentPageData['Page']['content']));?>" />
	<?php }?>
	<?php 
		if(isset($meta_keywords))
			echo $html->meta('keywords',$meta_keywords);
		if(isset($meta_description))
			echo $html->meta('description',strip_tags(str_replace('"',"",$meta_description)));
	?>
	<link rel="stylesheet" type="text/css" href="<?php echo $html->url("/fancybox/jquery.fancybox-1.3.1.css");?>" media="screen" />
	<?php echo $html->css('default.css?up');?>
	<?php echo $html->css('print',"",array("media"=>"print"));?>
	<?php if($currentPageData['Page']['lang']=="en") echo $html->css('en.css?up');?>
	<?php echo $javascript->link("prototype.js")?>
	<?php echo $javascript->link("page.js?ver=22")?>
	<?php //echo $javascript->link("scriptaculous.js")?>
	<?php echo $javascript->link('http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js'); ?>
	<?php echo $javascript->link("jquery.tools.min.js")?>
	<script type="text/javascript" src="<?php echo $html->url("/fancybox/jquery.mousewheel-3.0.2.pack.js");?>"></script>
	<script type="text/javascript" src="<?php echo $html->url("/fancybox/jquery.fancybox-1.3.1.js");?>"></script>
	<script type="text/javascript">
		var $j = jQuery.noConflict();
		homeUrl = "<?php echo $html->url("/");?>";
	</script>
</head>
<body>
	<div id="wrapper">
		<div id="site">
			<a name="top"></a>
			<div id="header"><?php echo $this->element("header")?></div>
			<div id="content"<?php if($this->params['action']=="index") echo " class='contentClear'";?>>
				<div id="footerTopBg" class="png"></div>
				<?php echo $content_for_layout;?>
			</div>
			<div id="footer"><?php echo $this->element("footer")?></div>
		</div>
	</div>
	<?php if($currentPageData['Page']['type']=="staff"){?>
		<div id="staffTooltip" style="display:none;">
			<div class="staffTooltipTick"></div>
			<div class="left staffTooltipLeft"></div>
			<div class="left staffTooltipBody">
				<div id="staffTooltipBodyName"></div>
				<div id="staffTooltipBodyText"></div>
			</div>
			<div class="left staffTooltipRight"></div>
			<div class="both"></div>
		</div>
	<?php }?>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-7593847-33', 'aidsisrael.org.il');
	  ga('send', 'pageview');
	
	</script>
</body>
</html>
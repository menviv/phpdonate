<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title><?php echo $title_for_layout; ?></title>
	<script type="text/javascript">
		homeUrl = "<?php echo $html->url("/");?>";
		adminUrl = homeUrl+"admin";
	</script>
	<?php
		//echo $html->meta('icon');
		echo $html->css('/admin/css/admin');
		echo $html->css('/admin/css/calendar');
		if(isset($site_direction) and $site_direction=="rtl")
			echo $html->css('/admin/css/rtl');
		echo $scripts_for_layout;
		echo $javascript->link('prototype');
		echo $javascript->link('/admin/js/calendar');
		echo $javascript->link('/admin/js/admin');
		echo $javascript->link('/admin/js/addition');
		echo $javascript->link('tiny_mce/tiny_mce');
		echo $javascript->link('scriptaculous.js?load=effects');
		
		echo $javascript->link('/admin/js/jquery-1.9.1.min');
		//echo $javascript->link("swfobject.js");
	?>
	<script type="text/javascript">
		jQuery.noConflict();
		var toolTipTexts = <?php echo $toolTipTexts;?>;
		Object.toJSON(toolTipTexts);
		currentUrl = "<?php echo $currentUrl;?>";
	</script>
</head>
<body>
	<div id="wrapper">
		<div id="site">
			<?php echo $this->element("header");?>
			<?php echo $content_for_layout; ?>
		</div>
		<div class="bgblackposition" id="bgblackposition" style="display: none;"></div>
	</div>
</body>
</html>
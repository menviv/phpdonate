<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset('UTF-8');?>
	<title>הוועד למלחמה באיידס</title>
	<?php echo $html->css('default.css?ver=updated');?>
	<?php echo $javascript->link("jquery-1.4.2.min.js")?>
</head>
<body>
	<div id="wrapper">
		<div id="site">
			<div class="donateSuc" style="text-align:center;"><?php echo $html->image("layout/success.jpg");?></div>
		</div>
	</div>
	<script type="text/javascript">
	$(document).ready(function(){
		setTimeout("callFunction()",3000);
	});
	function callFunction(){
		window.location = ("http://www.aidsisrael.org.il");
	}
	</script>
</body>
</html>
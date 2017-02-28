<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
	<?php $indexes = array_keys($analytics);?>
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Books');
		data.addColumn('number', 'Votes');
		data.addRows(<?php echo sizeof($scores);?>);
		<?php $counter=0;?>
		<?php foreach($scores as $key=>$value):?>
			data.setValue(<?php echo $counter;?>, 0, '<?php echo iconv("windows-1255","UTF-8",strrev(iconv("UTF-8","windows-1255",$survey['Survey']['answer'.$key])));?>');
			data.setValue(<?php echo $counter;?>, 1, <?php echo $value;?>);
			<?php $counter++;?>
		<?php endforeach;?>
		
		var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
		chart.draw(data, {width: 400, height: 300, title: '<?php echo iconv("windows-1255","UTF-8",strrev(iconv("UTF-8","windows-1255","תוצאות"/*$survey['Survey']['title']*/)));?>'});
	}
</script>
<div id="indexPage">
	<div class="pagetoptitle"><?php echo $survey['Survey']['title'];?></div>
	<div id="chart_div2"></div>
</div>
<style type="text/css">
.statRow{margin:5px 0 0 10px;}
.statRow a{text-decoration:none;color:#0D92CA;font-weight:bold;}
</style>
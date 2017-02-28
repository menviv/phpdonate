<?php 
class GraphComponent extends Object
{
	var $controller = true;
	var $openflashchart = "vendors/php-ofc-library/open-flash-chart.php";
	var $chartBgColor = "FFFFFF";
	function startup(&$controller)
	{
		// This method takes a reference to the controller which is loading it.
		// Perform controller initialization here.
	}
	function dot($col)
{    
    $default_dot = new dot();
    $default_dot
        ->size(3)
        ->halo_size(1)
        ->colour($col)
        ->tooltip('X: #x_label#<br>Y: #val#<br>#date:Y-m-d at H:i#');
    return $default_dot;
}

function green_dot()
{    
    return dot('#3D5C56');
}

	function dotGraph(){
		include_once $this->openflashchart;


$data_1 = array();
$data_2 = array();

// generate 31 data points
for( $i=1; $i<32; $i++ )
{
    $x = mktime(0, 0, 0, 1, $i, date('Y'));
    
    $y = (sin($i) * 2.5) + 10;
    $data_1[] = new scatter_value($x, $y);
    
    $data_2[] = (cos($i) * 1.9) + 4;
}

$def = new hollow_dot();
$def->size(3)->halo_size(2)->tooltip('#date:d M y#<br>Value: #val#');

$line = new scatter_line( '#DB1750', 3 ); 
$line->set_values($data_1);
$line->set_default_dot_style( $def );



//
// create an X Axis object
//
$x = new x_axis();
// grid line and tick every 10
$x->set_range(
    mktime(0, 0, 0, 1, 1, date('Y')),    // <-- min == 1st Jan, this year
    mktime(0, 0, 0, 1, 31, date('Y'))    // <-- max == 31st Jan, this year
    );
// show ticks and grid lines for every day:
$x->set_steps(86400);

$labels = new x_axis_labels();
// tell the labels to render the number as a date:
$labels->text('#date:l jS, M Y#');
// generate labels for every day
$labels->set_steps(86400);
// only display every other label (every other day)
$labels->visible_steps(2);
$labels->rotate(90);

// finally attach the label definition to the x axis
$x->set_labels($labels);


$y = new y_axis();
$y->set_range( 0, 15, 5 ); 

$chart = new open_flash_chart();
$title = new title( count($data_2) );
$chart->set_title( $title );
$chart->add_element( $line );
$chart->set_x_axis( $x );
$chart->set_y_axis( $y );

return $chart->toPrettyString();
	}
	function getBar($barTitle="",$data,$graphId,$threshold=array()){
		include_once $this->openflashchart;
		
		if(!empty($barTitle))
			$title = new title($barTitle);
			
		//$toolTipText = "#val# waiting<br>Max time waiting #x# min";
		$tags = new ofc_tags();
		$tags->font("Verdana", 10)
		    ->colour("#000000")
		    ->align_x_center();
		//    ->text('some text here');

		$values = array();
		$labels = array();
		$max = $data[0]['value'];
		$counter = 0;
		foreach ($data as $row):
			$max = max($max,$row['value']);
			$labels[] = $row['key'];
			$bar = new bar_value($row['value']);
			$color = $this->getColorBasedOnThreshold($row['value'],$threshold);
			$bar->set_colour($color);
			$values[] = $bar;
			//$tags->append_tag(new ofc_tag($counter, $row['value']));    
			if(isset($row['top'])){
				$t = new ofc_tag($counter,$row['value']);
				$t->text($row['top']);
				$tags->append_tag($t);
			}
			$counter++;
		endforeach;
		
		$bar = new bar_3d();
		$bar->set_values($values);
		$bar->colour = '#D54C78';
		
		//$x_axis = new x_axis();
		//$x_axis->set_3d(5);
		//$x_axis->colour = '#909090';
		//$x_axis->set_labels($labels);
		
		$chart = new open_flash_chart();
		//$chart->set_title($title);
		$chart->add_element($bar);
		$chart->add_element($tags);
		$chart->set_bg_colour('#FFFFFF');
		
		$y = new y_axis();
		$y->set_range(0,$max+20,10);
		$chart->set_y_axis($y);

		$x = new x_axis();
		$x->set_3d(5);
		$x->set_colour( '#909090' );
		$x->set_labels_from_array($labels);
		
		$chart->set_x_axis( $x );
		return $chart->toPrettyString();
	}
	function getPie($graphTitle="",$data,$graphId){
		include_once $this->openflashchart;
		if(!empty($graphTitle))
			$title = new title($graphTitle);
		$pie = new pie();
		$pie->start_angle(20)
		    ->add_animation(new pie_fade())
		    ->add_animation(new pie_bounce(7))
		    //->label_colour('#432BAF') // <-- uncomment to see all labels set to blue
		    ->gradient_fill()
		    ->tooltip( '#val# of #total#<br>#percent# of 100%' )
		    ->colours(
		        array(
		            '#1F8FA1',    // <-- blue
		            '#848484',    // <-- grey
		            '#CACFBE',    // <-- green
		            '#DEF799'    // <-- light green
		        ) );
		$pie->on_click("function(){graph_click('".$graphId."')}");
		$pie->set_values($data);
		$chart = new open_flash_chart();
		if(isset($title))
			$chart->set_title($title);
		$chart->add_element($pie);
		$chart->set_bg_colour('#'.$this->chartBgColor);
		return $chart->toPrettyString();
	}
	function getColorBasedOnThreshold($valuetocheck,$threshold){
		$color = "#ffeeff";
		$flag = false;
		ksort($threshold);
		$max = 0;
		foreach ($threshold as $key=>$value):
			if($flag===true)
				continue;
			if($valuetocheck<=$key){
				$color = $value;
				$flag = true;
			}
		endforeach;
		return $color;
	}
}
?>
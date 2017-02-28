<?php
if(isset($search) and $search=="true")
	$pageSymbolType = "&";
else 
	$pageSymbolType = "?";
$perpageLink = "";
if(isset($perpage))
	$perpageLink = '&perpage='.$perpage;
if($rows>1){?>
	<table cellpadding="0" cellspacing="5" dir="ltr">
		<tr>
			<?php 
			$next=$current+1;
			$previous=$current-1;
			$flag = "false";
			$mid_range = "8";
			$return = "";
			$start_range = $current - floor($mid_range/2);
            $end_range = $current + floor($mid_range/2)-1;
			if($start_range <= 0)
			{
				$end_range += abs($start_range)+1;
				$start_range = 1;
			}
			if($end_range > $rows)
			{
				$start_range -= $end_range-$rows;
				$end_range = $rows;
			}
			$range = range($start_range,$end_range);
			if($previous!=0){
				?><td class="bold paginatearrows"><a href="<?php echo $html->url($page.$pageSymbolType.'page='.$previous.$perpageLink);?>">«</a></td><?php
			}
			for($i=1;$i<=$rows;$i++)
            {
                if($range[0] > 2 And $i == $range[0]) $return .= "<td class=\"paginateregular bold\">...</td>";
                // loop through all pages. if first, last, or in range, display
                if($i==1 Or $i==$rows Or in_array($i,$range))
                {
                	$link = $html->link($i,$page.$pageSymbolType.'page='.$i.$perpageLink);
                    $return .= ($i == $current) ? "<td class=\"paginatecurrent bold\">$i</td> ":"<td class=\"paginateregular bold\">$link</td>";
                }
                if($range[$mid_range-1] < $rows-1 And $i == $range[$mid_range-1]) $return .= "<td class=\"paginateregular bold\">...</td>";
            }
            echo $return;
			if($rows!=1 and $next<$rows+1){
				?><td class="bold paginatearrows"><a href="<?php echo $html->url($page.$pageSymbolType.'page='.$next.$perpageLink);?>">»</a></td><?php
			}
			?>
		</tr>
	</table>
<?php }?>
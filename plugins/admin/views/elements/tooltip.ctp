<div id="tooltip" <?php if(!isset($tooltiptext) or empty($tooltiptext)) echo 'style="display: none;"';?><?php if(isset($tooltiptype) and $tooltiptype=="Error") echo ' class="tooltiperror"';?>>
	<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="tooltipleft"></td>
			<td class="tooltipcenter">
				<div class="left <?php if(isset($tooltiptype) and $tooltiptype=="Error") echo 'tooltipiconerror'; else echo 'tooltipiconok';?>" id="tooltipicon"></div>
				<div class="left" id="tooltiptext"><?php if(isset($tooltiptext) and !empty($tooltiptext)) echo $tooltiptext;?></div>
				<div class="right" id="tooltipcloseicon"><a href="javascript:void(0);" onclick="$('tooltip').style.display='none';"><?php echo $html->image("/admin/img/transparent.gif",array("class"=>"png"));?></a></div>
				<div class="both"></div>
			</td>
			<td class="tooltipright"></td>
		</tr>
	</table>
</div>
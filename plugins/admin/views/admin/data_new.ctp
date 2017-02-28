<script type="text/javascript">
	orderUrl = "<?php echo $html->url("/admin/getAjaxOrder/".$model);?>";
	orderType = "asc";
	lastField = "";
	deleteFileUrl = "<?php echo $html->url("/admin/deleteFileUrl/");?>";
</script>
<?php 
	if(!isset($formAction) or empty($formAction))
		$formAction = "/admin/dataManage/$model/newstore";
?>
<?php 
	if(isset($AjaxUrl))
		$AjaxUrl = $html->url($AjaxUrl);
	else 
		$AjaxUrl = false;
?>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<?php if(isset($aditionalmenu)){?><td style="width:199px;" valign="top"><?php echo $this->element("sidemenu");?></td><?php }?>
		<td valign="top">
			<div id="pagetoptitlecontainer">
				<?php if(isset($stages)){?>
					<div class="pagetoptitle"><?php echo $stages[$currentStage-1]['name'];?></div>
					<?php if(!isset($currentStage)) $currentStage="1";?>
					<div class="pagetopstage">Stage <?php echo $currentStage." of ".sizeof($stages);?></div>
				<?php }else{?>
					<?php if(isset($hardTopTitle)){?>
						<div class="pagetoptitle"><?php echo $hardTopTitle;?></div>
					<?php }else{?>
						<div class="pagetoptitle"><?php echo $topTitle;?></div>
					<?php }?>
				<?php }?>
			</div>
			<?php echo $this->element("tooltip");?>
			<?php 
				if(isset($stages) and isset($stages[$currentStage-1]['additional']))
					echo $this->element("additional/".$stages[$currentStage-1]['additional']);
				else
					echo $this->element("newdata",array("formAction"=>$html->url($formAction),"Ajax"=>$AjaxUrl));
			?>
		</td>
	</tr>
</table>
<?php //echo $this->element("paginate");?>
<div class="both"></div>
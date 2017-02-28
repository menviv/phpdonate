<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<?php if(isset($aditionalmenu)){?><td style="width:199px;" valign="top"><?php echo $this->element("sidemenu");?></td><?php }?>
		<td valign="top">
			<?php echo $this->element("tooltip");?>
			<?php if(isset($hardTopTitle)){?>
				<div class="pagetoptitle"><?php echo $hardTopTitle;?></div>
			<?php }else{?>
				<div class="pagetoptitle"><?php echo $topTitle;?></div>
			<?php }?>
			<?php echo $this->element("search");?>
			<div id="listData"><?php echo $this->element("lists");?></div>
			<div id="viewAllPaginate">
				<div id="listNumPerPage">
					<div class="left listNumPerPageText"><label for="paginatePerpage"><?php echo _LANG_LIST_SHOWPER;?></label></div>
					<div class="left"><?php echo $form->select("paginate.perpage",array(5=>5,10=>10,20=>20,30=>30,50=>50,"all"=>"All"),$perPageFilter,array("name"=>"perpage"),false);?></div>
					<div class="both"></div>
				</div>
				<?php echo $this->element("paginate");?>
			</div>
		</td>
	</tr>
</table>
<div class="both"></div>
<script type="text/javascript">
	orderUrl = "<?php echo $html->url("/admin/itemManagement/".$model);?>";
	orderType = "asc";
	lastField = "";
	Event.observe("paginatePerpage","change",changePerPage);
	function changePerPage(){
		passUrl = RemoveParameterFromUrl(currentUrl,"perpage");
		if (passUrl.indexOf("?")>=0)
			window.location = (passUrl+"&perpage="+$("paginatePerpage").value);
		else
			window.location = (passUrl+"?perpage="+$("paginatePerpage").value);
	}
	function RemoveParameterFromUrl(url,parameter){
		//if(typeof(parameter == "undefined") || parameter == null || parameter == "" )
			//throw new Error( "parameter is required" );
		url = url.replace(new RegExp("\\b" + parameter + "=[^&;]+[&;]?","gi"),"");
		// remove any leftover crud
		url = url.replace( /[&;]$/, "" );
		url = url.replace( /[?;]$/, "" );
		return url;
	}

</script>
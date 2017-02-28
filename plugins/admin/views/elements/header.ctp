<div id="header">
	<div id="adminlogo"><a href="<?php echo $html->url("/admin");?>"><?php echo $html->image("/admin/img/transparent.gif")?></a></div>
	<div id="welcomeuser">
		<div class="left"><?php echo _LANG_HEADER_WELCOME;?> <?php echo $userDetails['username'];?></div>
		<div class="left" id="welcomeusersep">|</div>
		<div class="left"><?php echo $html->link(_LANG_HEADER_EDITDETAILS,"/admin/editDetails");?></div>
		<div class="left" id="welcomeusersep">|</div>
		<div class="left"><?php echo $html->link(_LANG_HEADER_LOGOUT,"/admin/logout");?></div>
		<div class="both"></div>
	</div>
	<div id="headerlinksContainer">
		<?php foreach ($headercats as $headerlink):?>
			<?php 
				if(isset($headerlink['menu']) and isset($navModel) and $headerlink['menu']==$navModel)
					$class=" currentheaderlink";
				elseif($this->params['url']['url']=="admin".$headerlink['link'])
					$class=" currentheaderlink";
				else
					$class="";
			?>
			<h1 class="left headerlink<?php echo $class;?>"><?php echo $html->link($headerlink['name'],"/admin/".$headerlink['link'])?></h1>
		<?php endforeach;?>
		<div class="both"></div>
	</div>
</div>
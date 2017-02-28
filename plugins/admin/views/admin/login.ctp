<table cellpadding="0" cellspacing="0" width="100%" height="100%">
	<tr>
		<td>
			<div id="loginPage">
				<div id="loginlogo"><?php echo $html->image("/admin/img/layout/loginlogo.png",array("class"=>"png","alt"=>"הוועד למלחמה באיידס","title"=>"הוועד למלחמה באיידס"));?></div>
				<div id="loginbg" class="png"></div>
				<div id="logininputs">
					<form action="<?php echo $html->url("/admin/login");?>" method="post" id="loginform">
						<div id="loginUsernameRow" class="logininput"><?php echo $form->input("User.username",array("label"=>false,"div"=>false,"value"=>"USER NAME","onclick"=>"if(this.value=='USER NAME') this.value='';","onblur"=>"if(this.value=='') this.value='USER NAME';"));?></div>
						<div id="loginPasswordRow" class="logininput">
							<div class="left" id="loginpass">
								<?php echo $form->input("User.password",array("label"=>false,"div"=>false,"onclick"=>"$('loginpasstext').style.display='none';","onfocus"=>"$('loginpasstext').style.display='none';","onblur"=>"if(this.value=='') $('loginpasstext').style.display='block';"));?>
								<div id="loginpasstext">Password</div>
							</div>
							<div class="left" id="loginsubmit"><?php echo $form->submit("",array("div"=>false,"class"=>"png"));?></div>
							<div class="both"></div>
						</div>
						<div id="formError" class="logininput"></div>
					</form>
				</div>
			</div>
		</td>
	</tr>
</table>
<script type="text/javascript">
	url="<?php echo $html->url('/admin/index'); ?>";
	Event.observe('loginform','submit',sendLoginForm);
</script>
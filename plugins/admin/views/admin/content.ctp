<?=$form->create('Signup',array('id'=>'SignupForm','url'=>"/".$this->here));?>
	<h2>Step 1: Account Information</h2>
	<ul>
		<li><?=$form->input('Client.first_name', array('label'=>'First Name:','size'=>20,'div'=>false));?></li>
		<li><?=$form->input('Client.last_name', array('label'=>'Last Name:','size'=>20,'div'=>false));?></li>
		<li><?=$form->input('Client.phone', array('label'=>'Phone Number:','size'=>20,'div'=>false));?></li>
	</ul>
	<ul>
		<li><?=$form->input('User.email', array('label'=>'Email:','size'=>20,'div'=>false));?></li>
		<li><?=$form->input('User.password',array('label'=>'Password:','size'=>20,'div'=>false,));?></li>
		<li><?=$form->input('User.confirm',array('label'=>'Confirm:','size'=>20,'div'=>false,'type'=>'password'));?></li>
	</ul>
	<div class="submit">
		<?=$form->submit('Continue', array('div'=>false));?>
		<?=$form->submit('Cancel', array('name'=>'Cancel','div'=>false));?>
	</div>
<?=$form->end();?>

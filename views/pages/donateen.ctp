<?php echo $this->element("sideRight");?>
<div id="donatePage" class="leftSideSmall right">
	<?php echo $this->element("breadcrumbs");?>
	<div id="articlePageTop">
		<div id="articlePageTopImage"><?php echo $html->image("uploads/donate.png");?></div>
		<div id="articlePageTopTitle" class="topWidth"><?php echo $currentPageData['Page']['pname'];?></div>
		<div id="articlePageTopText" class="topWidth"><?php echo $currentPageData['Page']['content'];?></div>
	</div>
	<div id="donatetopText"><?php echo $currentPageData['Pages_param']['donate_text'];?></div>
	<div id="donateTable">
		<div class="right" id="donateTableRight">
			<div class="donateBox" style="height:180px;">
				<div class="donateBoxBg"><?php echo $html->image("layout/donateletteren.png");?></div>
				<div class="donateBoxTitle">Mail check</div>
				<div class="donateBoxText">
					Payable to “Israel AIDS Task Force,” payee only
					<br />
					Mailing address: Israel AIDS Task Force
					<br />
					P.O.B. 57310, Tel-Aviv 6157301
					<br />
					US and UK residents may also make a tax-deductible donation by check or bank transfer via the New Israel Fund. Please cite Israel AIDS Task Force's donor advised number ID# 5406 when making your contribution.
				</div>
			</div>
			<div class="donateBox" style="height:125px;">
				<div class="donateBoxBg"><?php echo $html->image("layout/donatephoneen.png");?></div>
				<div class="donateBoxTitle">Phone</div>
				<div class="donateBoxText"><div class="phoneDonate">03-5613000</div>Extension 101 <br />9 AM - 6 PM</div>
			</div>
			<div class="donateBox" style="height:185px !important;">
				<div class="donateBoxBg"><?php echo $html->image("layout/donatestandingorderen.png");?></div>
				<div class="donateBoxTitle">Standing Order</div>
				<div class="donateBoxText">
					You can donate to the Israel AIDS Task Force by means of a standing order, which you will have to create at your bank.
					<br />
					The donation will be a fixed sum, donated regularly and automatically. Please see below IATF's bank account details.
					<br />
					You can cancel your standing order independently at any time.
				</div>
			</div>
			<div class="donateBox" style="height:170px;">
				<div class="donateBoxBg"><?php echo $html->image("layout/donatebanken.png");?></div>
				<div class="donateBoxTitle">Wire transfer</div>
				<div class="donateBoxText">
					Bank Hapoalim B.M.
					<br />
					Branch: 772
					<br />
					Account no.: 388482
					<br />
					Account Name: "Israeli AIDS Task Force"
					<br />
					IBAN IL13-0127-7200-0000-0388-482
					<br />
					Swift: POALILIT
				</div>
			</div>
			<div class="donateBox" style="margin-bottom:0;height:155px;">
				<div class="donateBoxBg"><?php echo $html->image("layout/donateroundup.png");?></div>
				<div class="donateBoxTitle">Round-Up</div>
				<div class="donateBoxText">
				With every purchase you make using your credit card, the price will be rounded to the nearest Shekel.
				<br />
				The small change from Rounding-Up will be donated in full to the AIDS Task Force. 
				<br />
				Want to join? <?php echo $html->link("Click Here","http://www.round-up.org.il/?categoryId=37781&itemId=69976",array("target"=>"_blank"));?></div>
			</div>
			if you are a foreign resident and are interested in the reception - <a href="http://www.aidsisrael.org.il/img/uploads/items/14010461451003056406.pdf">Click Here</a>
		</div>
		<?php if(1==2){?><div class="right" style="margin-right:15px;"><?php echo $html->image("layout/donatesoon.jpg");?></div><?php }?>
		<div class="right" id="donateTableLeft">
			<div class="donateBoxBg"><?php echo $html->image("layout/donatevisaen.png");?></div>
			<div class="donateBoxTitle">Credit Card</div>
			<div id="donateForm">
				<form action="<?php echo $html->url("/ajax/sendDonate");?>" method="post" id="donateFormDataCon">
					<div class="donateFormCardText bold">Donation details</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle"><span class="require">Donate sum (NIS)</span></div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.amount",array("label"=>false,"div"=>false,"maxlength"=>5));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow" style="margin-bottom:25px;">
						<div class="right donateFormRowTitle"><span class="require">Number of payments</span></div>
						<div class="left donateFormRowInput"><?php echo $this->element("select",array("selectFirstValue"=>"","selectNameHidden"=>"data[donate][paymentsnum]","selects"=>array("1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5")));?></div>
						<?php if(1==2){?><div class="left donateFormRowInput"><?php echo $form->input("donate.paymentsnum",array("label"=>false,"div"=>false));?></div><?php }?>
						<div class="both"></div>
					</div>
					<div class="donateFormCardText bold">Donor details</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle"><span class="require">First name</span></div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.firstname",array("label"=>false,"div"=>false,"maxlength"=>50));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle"><span class="require">Last name</span></div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.lastname",array("label"=>false,"div"=>false,"maxlength"=>50));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle">Company name</div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.company",array("label"=>false,"div"=>false,"maxlength"=>50));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle"><span class="require">Street</span></div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.street",array("label"=>false,"div"=>false,"maxlength"=>50));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle"><span class="require">House no.</span></div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.housenumber",array("label"=>false,"div"=>false,"maxlength"=>5));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle">Apartment no.</div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.apartmentnumber",array("label"=>false,"div"=>false,"maxlength"=>3));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle"><span class="require">Town</span></div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.city",array("label"=>false,"div"=>false,"maxlength"=>50));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle">ZIP code</div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.zip",array("label"=>false,"div"=>false,"maxlength"=>7));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle"><span class="require">Phone</span></div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.phone",array("label"=>false,"div"=>false,"maxlength"=>11));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle">Additional phone</div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.phone2",array("label"=>false,"div"=>false,"maxlength"=>11));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle">Fax</div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.fax",array("label"=>false,"div"=>false,"maxlength"=>11));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow" style="margin-bottom:15px;">
						<div class="right donateFormRowTitle">E-mail</div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.email",array("label"=>false,"div"=>false,"maxlength"=>50));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow">
						<div class="right donateFormRowCheckbox"><input type="checkbox" name="data[donate][receipt]"/></div>
						<div class="right donateFormRowCheckboxText">Please send a donation receipt to the above address</div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow donateFormSubmit" style="margin-bottom:15px;">
						<div class="right" id="donateFormReturn"></div>
						<div class="left donateFormRowInput donateFormRowInputSubmit"><?php echo $form->submit("Continue",array("label"=>false,"div"=>false));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow donateFormRowThanku">A donation confirmation will be sent within a few days.<br /><span class="bold">We thank you for your support</span></div>
					<div class="donateFormRowThankuSep"></div>
					<div class="donateFormRow donateFormRowRequireText">Fields marked with * are required</div>
				</form>
			</div>
		</div>
		<div class="both"></div>
	</div>
	<div class="donateBoxTextBottom"><div class="bold" style="margin-bottom:5px;">Donations are recognized for tax purposes according to section 46 of the income tax code.</div>
		The AIDS Task Force maintains strict standards of proper administration and maximal transparency. We believe that these values, indicating integrity and professionalism, are key to wholesome action for individuals and society. If you are interested in looking at the organization’s financial reports, you can do so on the [LINK: Organizational Transparency page]	<?php echo $html->link("Organizational Transparency page","/en/Organizationaltransparency");?>
	</div>
</div>
<div class="both"></div>
<script type="text/javascript">
	initSelect();
	Event.observe('donateFormDataCon','submit',sendDonateForm);
</script>
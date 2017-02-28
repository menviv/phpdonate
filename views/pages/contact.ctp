<?php echo $this->element("sideRight");?>
<div id="contactPage" class="leftSideSmall right">
	<?php echo $this->element("breadcrumbs");?>
	<div id="articlePageTop">
		<div id="articlePageTopImage"><?php echo $html->image("uploads/contact.png");?></div>
		<div id="articlePageTopTitle" class="topWidth"><?php echo $currentPageData['Page']['pname'];?></div>
		<div id="articlePageTopText" class="topWidth"><?php echo $currentPageData['Page']['content'];?></div>
	</div>
	<div id="contactPageBefore">
		<div id="contactPageBeforeText">רגע לפני יצירת הקשר, נא בידקו האם <br />שאלתכם לא נמצאת בין השאלות הנפוצות</div>
		<div id="contactPageBeforeIcons">
			<div class="right contactPageBeforeItemImage"><a href="<?php echo $html->url("/qwe");?>"><?php echo $html->image("layout/contact1.png");?></a></div>
			<div class="right contactPageBeforeItemContent">
				<div class="contactPageBeforeItemContentTitle"><?php echo $html->link("דרכי הדבקה ובדיקות","/qwe");?></div>
				<div class="contactPageBeforeItemContentText"><a href="<?php echo $html->url("/qwe");?>">ממה נדבקים? היכן נבדקים? ומה המשמעות כל תוצאה?</a></div>
			</div>
			<div class="right contactPageBeforeItemImage"><a href="<?php echo $html->url("/faq");?>"><?php echo $html->image("layout/contact2.png");?></a></div>
			<div class="right contactPageBeforeItemContent">
				<div class="contactPageBeforeItemContentTitle"><?php echo $html->link("שאלות נפוצות","/faq");?></div>
				<div class="contactPageBeforeItemContentText"><a href="<?php echo $html->url("/faq");?>">כל התשובות לכל מה שאי פעם רציתם לדעת על HIV</a></div>
			</div>
			<div class="right contactPageBeforeItemImage"><a href="<?php echo $html->url("/donate");?>"><?php echo $html->image("layout/contact3.png");?></a></div>
			<div class="right contactPageBeforeItemContent">
				<div class="contactPageBeforeItemContentTitle"><?php echo $html->link("תרומות","/donate");?></div>
				<div class="contactPageBeforeItemContentText"><a href="<?php echo $html->url("/donate");?>">רוצים לעזור לנו כדי שנוכל להמשיך ולעזור לאחרים? לחצו כאן</a></div>
			</div>
			<div class="both"></div>
		</div>
	</div>
	<div class="contactSep"></div>
	<div id="contactForm">
		<div id="contactFormTitle">מלאו פרטיכם ונציגינו יחזור אליכם בהקדם</div>
		<div id="contactFormData">
			<form action="<?php echo $html->url("/contact");?>" method="post" id="contactFormDataForm">
				<div class="right contactFormRight">
					<div class="contactFormRow">
						<div class="right contactFormRowTitle">*שם:</div>
						<div class="right contactFormRowInput"><?php echo $form->input("contact.firstname",array("div"=>false,"label"=>false));?></div>
						<div class="both"></div>
					</div>
					<div class="contactFormRow">
						<div class="right contactFormRowTitle">שם משפחה:</div>
						<div class="right contactFormRowInput"><?php echo $form->input("contact.lastname",array("div"=>false,"label"=>false));?></div>
						<div class="both"></div>
					</div>
					<div class="contactFormRow">
						<div class="right contactFormRowTitle">טלפון:</div>
						<div class="right contactFormRowInput"><?php echo $form->input("contact.phone",array("div"=>false,"label"=>false));?></div>
						<div class="both"></div>
					</div>
					<div class="contactFormRow">
						<div class="right contactFormRowTitle">נייד:</div>
						<div class="right contactFormRowInput"><?php echo $form->input("contact.cell",array("div"=>false,"label"=>false));?></div>
						<div class="both"></div>
					</div>
				</div>
				<div class="right contactFormLeft">
					<div class="contactFormRow">
						<div class="right contactFormRowTitle">*דוא"ל:</div>
						<div class="right contactFormRowInput"><?php echo $form->input("contact.email",array("div"=>false,"label"=>false));?></div>
						<div class="both"></div>
					</div>
					<div class="contactFormRow">
						<div class="right contactFormRowTitle">*נושא הפנייה:</div>
						<div class="right contactFormRowInput" style="width:157px;"><?php echo $this->element("select",array("selectFirstValue"=>$contactSubject[7],"selectNameHidden"=>"data[contact][subject]","selects"=>$contactSubject,"firstValue"=>7));?></div>
						<?php if(1==2){?><div class="right contactFormRowInput"><?php echo $form->select("contact.subject",$contactSubject,"",array("empty"=>false));?></div><?php }?>
						<div class="both"></div>
					</div>
					<div class="contactFormRow">
						<div class="right contactFormRowTitle">פרט:</div>
						<div class="right contactFormRowTextarea"><?php echo $form->textarea("contact.text");?></div>
						<div class="both"></div>
					</div>
				</div>
				<div class="both"></div>
				<div class="right" id="contactFormReturn"></div>
				<div class="left contactFormRowSubmit"><?php echo $form->submit("שלח",array("div"=>false));?></div>
				<div class="both"></div>
			</form>
		</div>
	</div>
	<div id="contactBottomBoxes">
		<div class="right donateBox">
			<div class="donateBoxBg"><?php echo $html->image("layout/contactaddress.png");?></div>
			<div class="donateBoxTitle">כתובת</div>
			<div class="donateBoxText">הוועד למלחמה באיידס <br />רחוב הנצי"ב 18, ת"א. </div>
		</div>
		<div class="right donateBox" style="margin-right:35px;">
			<div class="donateBoxBg"><?php echo $html->image("layout/post.png");?></div>
			<div class="donateBoxTitle">כתובת למשלוח דואר</div>
			<div class="donateBoxText">ת.ד. 57310, ת"א. מיקוד 61572 </div>
		</div>
		<div class="both"></div>
	</div>
</div>
<div class="both"></div>
<script type="text/javascript">
	initSelect();
	Event.observe('contactFormDataForm','submit',sendContactForm);
</script>
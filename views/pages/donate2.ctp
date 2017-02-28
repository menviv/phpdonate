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
			<div class="donateBox">
				<div class="donateBoxBg"><?php echo $html->image("layout/donateletter.png");?></div>
				<div class="donateBoxTitle">המחאה בדואר</div>
				<div class="donateBoxText">לפקודת "הוועד למלחמה באיידס" למוטב בלבד. <br />כתובת למשלוח: הוועד למלחמה באיידס, <br />ת.ד. 57310 תל-אביב מיקוד 61572</div>
			</div>
			<div class="donateBox">
				<div class="donateBoxBg"><?php echo $html->image("layout/donatephone.png");?></div>
				<div class="donateBoxTitle">טלפון</div>
				<div class="donateBoxText"><div class="phoneDonate">03-5613000</div>שלוחה 101 <br />בין השעות 9:00-18:00</div>
			</div>
			<div class="donateBox">
				<div class="donateBoxBg"><?php echo $html->image("layout/donatestandingorder.png");?></div>
				<div class="donateBoxTitle">הוראת קבע</div>
				<div class="donateBoxText"><a href="">הורדת טופס</a><br />יש למלא את הטופס ולשלוח לפקס 03-5611764 <br />ולוודא קבלה ב-03-5613000 שלוחה 101</div>
			</div>
			<div class="donateBox">
				<div class="donateBoxBg"><?php echo $html->image("layout/donatebank.png");?></div>
				<div class="donateBoxTitle">העברה בנקאית</div>
				<div class="donateBoxText">בנק הפועלים (מספר 12) <br /> סניף 772 <br />חשבון 388482</div>
			</div>
			<div class="donateBox" style="margin-bottom:0;;">
				<div class="donateBoxBg"><?php echo $html->image("layout/donateroundup.png");?></div>
				<div class="donateBoxTitle">עיגול לטובה</div>
				<div class="donateBoxText">בכל רכישה שתבצעו באמצעות כרטיס<br /> האשראי שלכם, יעוגל סכום הקניה לשקל הקרוב.<br /> האגורות שיעוגלו, יתרמו במלואן לוועד למלחמה באיידס. מעוניינים להצטרף ? <?php echo $html->link("הקישו כאן","http://www.round-up.org.il/?categoryId=37781&itemId=69976",array("target"=>"_blank"));?></div>
			</div>
		</div>
		<?php if(1==2){?><div class="right" style="margin-right:15px;"><?php echo $html->image("layout/donatesoon.jpg");?></div><?php }?>
		<?php if(2==2){?>
		<div class="right" id="donateTableLeft">
			<div class="donateBoxBg"><?php echo $html->image("layout/donatevisa.png");?></div>
			<div class="donateBoxTitle">כרטיס אשראי</div>
			<div id="donateForm">
				<form action="<?php echo $html->url("/ajax/sendDonate");?>" method="post" id="donateFormDataCon">
					<div class="donateFormCardText bold">פרטי התרומה</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle"><span class="require">סכום התרומה בש"ח</span></div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.amount",array("label"=>false,"div"=>false,"maxlength"=>5));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow" style="margin-bottom:25px;">
						<div class="right donateFormRowTitle"><span class="require">מספר תשלומים</span></div>
						<div class="left donateFormRowInput"><?php echo $this->element("select",array("selectFirstValue"=>"","selectNameHidden"=>"data[donate][paymentsnum]","selects"=>array("1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5")));?></div>
						<?php if(1==2){?><div class="left donateFormRowInput"><?php echo $form->input("donate.paymentsnum",array("label"=>false,"div"=>false));?></div><?php }?>
						<div class="both"></div>
					</div>
					<div class="donateFormCardText bold">פרטי התורם</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle"><span class="require">שם פרטי</span></div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.firstname",array("label"=>false,"div"=>false,"maxlength"=>50));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle"><span class="require">שם משפחה</span></div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.lastname",array("label"=>false,"div"=>false,"maxlength"=>50));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle">שם החברה</div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.company",array("label"=>false,"div"=>false,"maxlength"=>50));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle"><span class="require">רחוב</span></div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.street",array("label"=>false,"div"=>false,"maxlength"=>50));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle"><span class="require">מס’ בית</span></div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.housenumber",array("label"=>false,"div"=>false,"maxlength"=>5));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle">מס דירה</div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.apartmentnumber",array("label"=>false,"div"=>false,"maxlength"=>3));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle"><span class="require">ישוב</span></div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.city",array("label"=>false,"div"=>false,"maxlength"=>50));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle">מיקוד</div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.zip",array("label"=>false,"div"=>false,"maxlength"=>7));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle"><span class="require">טלפון</span></div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.phone",array("label"=>false,"div"=>false,"maxlength"=>11));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle">טלפון נוסף</div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.phone2",array("label"=>false,"div"=>false,"maxlength"=>11));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow">
						<div class="right donateFormRowTitle">פקס</div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.fax",array("label"=>false,"div"=>false,"maxlength"=>11));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow" style="margin-bottom:15px;">
						<div class="right donateFormRowTitle">דוא”ל</div>
						<div class="left donateFormRowInput"><?php echo $form->input("donate.email",array("label"=>false,"div"=>false,"maxlength"=>50));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow">
						<div class="right donateFormRowCheckbox"><input type="checkbox" name="data[donate][receipt]"/></div>
						<div class="right donateFormRowCheckboxText">אני מעוניין שקבלה על התרומה תשלח לכתובת הנ”ל</div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow donateFormSubmit" style="margin-bottom:15px;">
						<div class="right" id="donateFormReturn"></div>
						<div class="left donateFormRowInput donateFormRowInputSubmit"><?php echo $form->submit("המשך",array("label"=>false,"div"=>false));?></div>
						<div class="both"></div>
					</div>
					<div class="donateFormRow donateFormRowThanku">אישור לקבלת התרומה ישלח תוך מספר ימים.<br /><span class="bold">אנו מודים על תמיכתך</span></div>
					<div class="donateFormRowThankuSep"></div>
					<div class="donateFormRow donateFormRowRequireText">שדות מסומנים ב- <span class="require"></span> הינם שדות חובה</div>
				</form>
			</div>
		</div>
		<?php }?>
		<div class="both"></div>
	</div>
	<div class="donateBoxTextBottom"><div class="bold" style="margin-bottom:5px;">התרומה מוכרת לצורך החזרי מס לפי סעיף 46 לפקודת מס הכנסה.</div>הוועד למלחמה באיידס מנוהל תוך הקפדה ושמירה על עקרונות של מנהל תקין ושקיפות מרבית. אנו מאמינים שהקפדה על ערכים אלו, המעידים על טוהר מידות ומקצועיות, היא המפתח לעשייה בריאה למען הפרט והחברה. במידה ואתם מעוניינים לעיין בדו"חות הכספיים של הארגון, <br />תוכלו לעשות זאת בעמוד <?php echo $html->link("השקיפות הארגונית","/vaad/organizational_transparency");?></div>
</div>
<div class="both"></div>
<script type="text/javascript">
	initSelect();
	Event.observe('donateFormDataCon','submit',sendDonateForm);
</script>
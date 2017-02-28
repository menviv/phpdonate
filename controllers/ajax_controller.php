<?php
class AjaxController extends AppController {
	var $name = 'Ajax';
	var $components = array("Session","Mail");
	var $uses = array("Donation");
	var $helpers = array('Html', 'Text', 'Javascript');
	function beforeFilter(){
		parent::beforeFilter();
	}
	function sendDonations(){
		die();
		$donations = $this->Donation->find("all",array("conditions"=>"status='done' and  dateAdd>='2012-09-01 00:00:00'"));
		//print_r($donations);die();
		$emailText = <<<EOF
<div style="direction:rtl;text-align:right">
התקבלה תרומה חדשה מאתר הוועד למלחמה באיידס
<br />
פרטים:
<br />
שם : %name%
<br />
שם חברה : %company%
<br />
טלפון : %phone%
<br />
נייד : %phone2%
<br />
פקס : %fax%
<br />
דואל : %email%
<br />
עיר : %city%
<br />
רחוב : %street%
<br />
מספר בית : %housenumber%
<br />
מספר דירה : %apartmentnumber%
<br />
מיקוד : %zip%
<br />
סכום תרומה : %amount%
<br />
מספר תשלומים : %payments%
<br />
מעוניין בקבלה : %receipt%
<br />
<br />
מערכת האתר
</div>
EOF;
		foreach($donations as $donation):
			$emailTextReplace = $this->replaceArr($emailText,array("%name%"=>$donation['Donation']['firstname']." ".$donation['Donation']['lastname'],"%company%"=>$donation['Donation']['company'],"%phone%"=>$donation['Donation']['phone'],"%phone2%"=>$donation['Donation']['phone2'],"%fax%"=>$donation['Donation']['fax'],"%email%"=>$donation['Donation']['email'],"%city%"=>$donation['Donation']['city'],"%street%"=>$donation['Donation']['street'],"%housenumber%"=>$donation['Donation']['housenumber'],"%apartmentnumber%"=>$donation['Donation']['apartmentnumber'],"%zip%"=>$donation['Donation']['zip'],"%amount%"=>$donation['Donation']['amount'],"%payments%"=>$donation['Donation']['payments'],"%receipt%"=>($donation['Donation']['receipt']=="true") ? "כן" : "לא"));
			$this->Mail->sendMail("התקבלה תרומה חדשה מאתר הוועד למלחמה באיידס",$emailTextReplace,"shico@quatro-digital.com,yaniv@quatro-digital.com","no-reply@aidsisrael.org.il");
		endforeach;
		die();
	}
	function donateresponse(){
		if(isset($_GET['ErrorCode'])){
			$text = iconv("windows-1255","utf-8",$_GET['ErrorText']);
			//echo $text;
			die();
		}
		if(!isset($_GET['uniqueID']) or !is_numeric($_GET['uniqueID'])){
			$this->redirect("/");
			die();
		}
		$uid = $_GET['uniqueID'];
		if(!$found = $this->Donation->find("uniqueid='".$_GET['uniqueID']."' and status='pending'")){
			$this->redirect("/");
			die();
		}
		$this->Donation->id = $found['Donation']['id'];
		$this->Donation->saveField("status","done");
		
		$emailText = <<<EOF
<div style="direction:rtl;text-align:right">
התקבלה תרומה חדשה מאתר הוועד למלחמה באיידס
<br />
פרטים:
<br />
שם : %name%
<br />
שם חברה : %company%
<br />
טלפון : %phone%
<br />
נייד : %phone2%
<br />
פקס : %fax%
<br />
דואל : %email%
<br />
עיר : %city%
<br />
רחוב : %street%
<br />
מספר בית : %housenumber%
<br />
מספר דירה : %apartmentnumber%
<br />
מיקוד : %zip%
<br />
סכום תרומה : %amount%
<br />
מספר תשלומים : %payments%
<br />
מעוניין בקבלה : %receipt%
<br />
<br />
מערכת האתר
</div>
EOF;
		$emailText = $this->replaceArr($emailText,array("%name%"=>$found['Donation']['firstname']." ".$found['Donation']['lastname'],"%company%"=>$found['Donation']['company'],"%phone%"=>$found['Donation']['phone'],"%phone2%"=>$found['Donation']['phone2'],"%fax%"=>$found['Donation']['fax'],"%email%"=>$found['Donation']['email'],"%city%"=>$found['Donation']['city'],"%street%"=>$found['Donation']['street'],"%housenumber%"=>$found['Donation']['housenumber'],"%apartmentnumber%"=>$found['Donation']['apartmentnumber'],"%zip%"=>$found['Donation']['zip'],"%amount%"=>$found['Donation']['amount'],"%payments%"=>$found['Donation']['payments'],"%receipt%"=>($found['Donation']['receipt']=="true") ? "כן" : "לא"));
		$this->Mail->sendMail("התקבלה תרומה חדשה מאתר הוועד למלחמה באיידס",$emailText,"finance@aidsisrael.org.il","no-reply@aidsisrael.org.il");
		echo $this->render("/pages/donatesuccess","emptyLayout");
		die();
	}
	function replaceArr($string,$replaceArray){
		foreach ($replaceArray as $key=>$value):
			$string = str_replace($key,$value,$string);
		endforeach;
		return $string;
	}
	function sendDonate(){
		/**
		TODO
			1.Check the transaction id before sending the user
			3.admin for the donations
			4.email after donation has been fully sent?
			6.change from demo to active
			7.wtf is authNumber???
		**/
		if(!$this->checkAjaxFromOwnDomain()){
			$this->redirect("/");
			die();
		}
		$require = array("amount","paymentsnum","firstname","lastname","street","housenumber","city","phone");
		if(!$this->checkIfIsset($this->data['donate'],$require) or !$this->checkIfNotEmpty($this->data['donate'],$require)){
			echo json_encode(array("return"=>"Error","returntext"=>"אנא הזן את שדות החובה"));
			die();
		}
		if(!is_numeric($this->data['donate']['amount'])){
			echo json_encode(array("return"=>"Error","returntext"=>"אנא הזן סכום תרומה תקין"));
			die();
		}
		if(!is_numeric($this->data['donate']['paymentsnum']) or $this->data['donate']['paymentsnum']>5 or $this->data['donate']['paymentsnum']<1){
			echo json_encode(array("return"=>"Error","returntext"=>"אנא הזן מספר תשלומים תקין"));
			die();
		}
		if(!is_numeric($this->data['donate']['housenumber'])){
			echo json_encode(array("return"=>"Error","returntext"=>"אנא הזן מספר בית תקין"));
			die();
		}
		if(!empty($this->data['donate']['apartmentnumber']) and !is_numeric($this->data['donate']['apartmentnumber'])){
			echo json_encode(array("return"=>"Error","returntext"=>"אנא הזן מספר דירה תקין"));
			die();
		}
		if(!$this->__checkPhone($this->data['donate']['phone'])){
			echo json_encode(array("return"=>"Error","returntext"=>"אנא הזן מספר טלפון תקין"));
			die();
		}
		if(!empty($this->data['donate']['phone2']) and !$this->__checkPhone($this->data['donate']['phone2'])){
			echo json_encode(array("return"=>"Error","returntext"=>"אנא הזן מספר טלפון נוסף תקין"));
			die();
		}
		if(!empty($this->data['donate']['fax']) and !$this->__checkPhone($this->data['donate']['fax'])){
			echo json_encode(array("return"=>"Error","returntext"=>"אנא הזן מספר פקס תקין"));
			die();
		}
		if(!empty($this->data['donate']['email']) and !$this->Mail->valid_email($this->data['donate']['email'])){
			echo json_encode(array("return"=>"Error","returntext"=>"אנא הזן כתובת מייל תקנית"));
			die();
		}
		$data = $this->validCleanVar($this->data['donate'],"return");
		//define("HTTP_POST_URL","https://cgmpiuat.creditguard.co.il/CGMPI_Server/CreateTransactionExtended");
		define("HTTP_POST_URL","https://cgmpi.creditguard.co.il/CGMPI_Server/CreateTransactionExtended");
		App::import('Vendor', 'creditguard/creditguard');
		// postRequest (key,iv,url,userName,password,o_MID,terminal,mainTerminalNumber,amount,o_currency,transactionType,creditType,transactionCode,authNumber,numberOfPayments,firstPayment,periodicalPayment,validationType,dealerNumber,description,email,langID,clientIP,xRem,userData1,userData2,userData3,userData4,userData5,userData6,userData7,userData8,userData9,userData10)
		$uniqueID = time().rand(100,1000);
		if($this->data['donate']['paymentsnum']>1){
			$float = $this->data['donate']['amount']/$this->data['donate']['paymentsnum'];
			$perPayment = intval($float);
			if($float!=$perPayment){
				$firstPayment = $this->data['donate']['amount']-$perPayment*($this->data['donate']['paymentsnum']-1);
				$nextPayments = $perPayment;
			}else{
				$firstPayment = $perPayment;
				$nextPayments = $perPayment;
			}
			$firstPayment = 100*$firstPayment;
			$nextPayments = 100*$nextPayments;
			//echo $this->data['donate']['paymentsnum']." ".$firstPayment." ".$nextPayments;
			//die();
			$transactionId = postRequest($uniqueID,"","",HTTP_POST_URL,"aids","e7$74.4D3E86","10153","8800616","",$this->data['donate']['amount']*100,"ILS","Debit","Payments","Phone","",$this->data['donate']['paymentsnum']-1,$firstPayment,$nextPayments,"autoComm","","",$this->data['donate']['email'],"HE","","","","","","","","","","","","");
		}
		else
			$transactionId = postRequest($uniqueID,"","",HTTP_POST_URL,"aids","e7$74.4D3E86","10153","8800616","",$this->data['donate']['amount']*100,"ILS","Debit","RegularCredit","Phone","","","","","autoComm","","",$this->data['donate']['email'],"HE","","","","","","","","","","","","");
		$xml = $this->loadFieldsFromXml($transactionId);
		if(!isset($xml['Ashrait']['Mpi']['Response']['txId']))
			die();
		$txid = $xml['Ashrait']['Mpi']['Response']['txId'];
		//$redirectUrl = "https://cgmpiuat.creditguard.co.il/CGMPI_Server/PerformTransaction?txId=".$transactionId;
		$redirectUrl = "https://cgmpi.creditguard.co.il/CGMPI_Server/PerformTransaction?txId=".$txid;
		//if($transactionId)
		$newDonate['id'] = "";
		$newDonate['uniqueid'] = $uniqueID;
		$newDonate['amount'] = $data['amount'];
		$newDonate['payments'] = $data['paymentsnum'];
		$newDonate['firstname'] = $data['firstname'];
		$newDonate['lastname'] = $data['lastname'];
		$newDonate['company'] = $data['company'];
		$newDonate['street'] = $data['street'];
		$newDonate['housenumber'] = $data['housenumber'];
		$newDonate['apartmentnumber'] = $data['apartmentnumber'];
		$newDonate['city'] = $data['city'];
		$newDonate['zip'] = empty($data['zip']) ? 0 : $data['zip'];
		$newDonate['phone'] = $data['phone'];
		$newDonate['phone2'] = $data['phone2'];
		$newDonate['fax'] = $data['fax'];
		$newDonate['email'] = $data['email'];
		$newDonate['status'] = "pending";
		$newDonate['transactionnum'] = $txid;
		$newDonate['receipt'] = isset($data['receipt']) ? "true" : "false";
		$this->Donation->save($newDonate);
		echo json_encode(array("return"=>"Done","returntext"=>"הנך מועבר","url"=>$redirectUrl));
		die();
	}
	function __checkPhone($str=""){
		$check = str_replace(" ","",$str);
		$dashCount = substr_count($check, '-');
		if($dashCount>1){
			return false;
		}
		$check = str_replace("-","",$check);
		if(!is_numeric($check))
			return false;
		if(strlen(utf8_decode($check))<9 or strlen(utf8_decode($check))>10)
			return false;
		if(substr($check,1,1)=="0"){
			return false;
		}
		return $check;
	}
	function loadFieldsFromXml($parsed_xml){
	    // import XML class
	    App::import('Xml');
	    // now parse it
	    $parsed_xml =& new XML($parsed_xml);
	    $parsed_xml = Set::reverse($parsed_xml);
		 // see the returned array
	    return $parsed_xml;
	}
}
?>
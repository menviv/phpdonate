<?php
class AjaxController extends AppController {
	var $name = 'Ajax';
	var $components = array("Session","Mail");
	var $uses = array("Donation");
	var $helpers = array('Html', 'Text', 'Javascript');
	function beforeFilter(){
		parent::beforeFilter();
	}
	function donateresponse(){
		print_r($_POST);
		print_r($_GET);
		print_r($_SERVER);
		die();
	}
	function sendDonate(){
		/**
		TODO
			1.Check the transaction id before sending the user
			2.Show the user popup before sending him? => NO!
			3.admin for the donations
			4.email after donation has been fully sent?
			5.callback after the user submit the form at the url
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
		die();
		define("HTTP_POST_URL","https://cgmpiuat.creditguard.co.il/CGMPI_Server/CreateTransactionExtended");
		App::import('Vendor', 'creditguard/creditguard');
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
			$transactionId = postRequest($uniqueID,"","",HTTP_POST_URL,"aids","4$43b-b5428B","7","0962835","",$this->data['donate']['amount']*100,"ILS","Debit","Payments","Phone","1111",$this->data['donate']['paymentsnum'],$firstPayment,$nextPayments,"autoComm","","",$this->data['donate']['email'],"HE","","","","","","","","","","","","");
		}
		else
			$transactionId = postRequest($uniqueID,"","",HTTP_POST_URL,"aids","4$43b-b5428B","7","0962835","",$this->data['donate']['amount']*100,"ILS","Debit","RegularCredit","Phone","1111","","","","autoComm","","",$this->data['donate']['email'],"HE","","","","","","","","","","","","");
		$redirectUrl = "https://cgmpiuat.creditguard.co.il/CGMPI_Server/PerformTransaction?txId=".$transactionId;
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
		$newDonate['transactionnum'] = $transactionId;
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
}
?>
<?php
class AppController extends Controller {
	var $uses = array();
	var $helpers = array("Html","Javascript",'Form');
	var $components = array("RequestHandler");
	var $view = 'Functions';
	public function beforeFilter() {
	
   	}
   	function getGlobalVars(){
   		
   	}
   	/**
	 * check seesion of the user to check if he is online or not he will be redirect to login
	 *
	 */
	function checkSession(){
		if (!$this->Session->check('User'))
		{
			// Force the user to login
			$this->redirect('/login');
			die();
		}
    }
   	/**
   	 * activate user .
   	 * the function will send email to the user with his account activation link and will turn the user to an active user.
   	 *
   	 * @param unknown_type $user_id
   	 * @return unknown
   	 */
   	
	/**
	 * check if the var is clean for insert in db
	 * can be for check => return true or false
	 * or for clean=> return clean var for db
	 *
	 * @param string/array $var
	 * @param string $type
	 * @return string/array
	 */
   	 public function validCleanVar($var,$type="check"){
    	uses('sanitize');
		$mrClean = new Sanitize();
		$newArray=array();
		$flag=true;
		if(is_array($var)){
			foreach ($var as $key=>$checkVar):
				if(!is_string($checkVar))
					continue;
				$newArray[$key]=$mrClean->escape($checkVar);
				if($newArray[$key]==$checkVar and $flag==true)
					$flag=true;
				else 
					$flag=false;
			endforeach;
		}
		else{
			$newArray=$mrClean->escape($var);
			if($newArray==$var)
				$flag=true;
			else 
				$flag=false;
		}
		if($type=="check")
			return $flag;
		else 
			return $newArray;
    }
    /**
	 * check if the require fields in the array is not empty 
	 *
	 * @param array $array
	 * @param array $require
	 * @return true or false
	 */
	function checkIfNotEmpty($array,$require){
		foreach ($array as $key=>$value) {
			if(in_array($key,$require)){
				if(empty($value))
					return false;
			}
		}
		return true;
	}
	function checkIfIsset($array,$require){
		foreach ($require as $item) {
			if(!isset($array[$item])){
				return false;
			}
		}
		return true;
	}
	public function errorManage($page,$errorType){
		if(isset($this->params['url']['ur']))
			$url = $this->params['url']['ur'];
		else
			$url = "";
    	if(!empty($this->user['id']))
    		$this->log('Page: '.$page.' Error: '.$errorType.' Ip: '.$_SERVER['REMOTE_ADDR'].' Url: '.$url.' User: '.$this->user['id']); 
    	else
    		$this->log('Page: '.$page.' Error: '.$errorType.' Ip: '.$_SERVER['REMOTE_ADDR'].' Url: '.$url);
    }
    /**
	 * generate code for confirm things,passreset,confirm mail and more
	 *
	 * @param int $len
	 * @param string $model
	 * @param string $key
	 * @return string code
	 */
	public function generateCode($len,$model,$key){
		$code=$this->getRand($len,$model,$key);
		return $code;
	}
	/**
	 * get random link if dont already in db
	 *
	 * @param int $len
	 * @param string $model
	 * @param string $key
	 * @return string code
	 */
	public function getRand($len,$model,$key){
		do{
			$link=$this->randomLink($len);
			$retVal = $this->$model->find("$key='$link'");
		}while(!empty($retVal));
		return $link;	
	}
	/**
	 * generate the link
	 *
	 * @param int $len
	 * @return string code
	 */
	public function randomLink($len){
		$chars = '-ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$string = "";
		for ($i = 0; $i < $len; $i++)
		{
			$pos = rand(0, strlen($chars)-1);
			$string .= $chars{$pos};
		}
		return $string;	
	}
	function checkAjaxFromOwnDomain(){
		if($this->RequestHandler->isAjax()){
			$reffer = $this->RequestHandler->getReferer();
			if($reffer==$_SERVER['HTTP_HOST'])
				return true;
		}
		return false;
	}
}
?>
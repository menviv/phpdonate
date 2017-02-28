<?php 
class AppModel extends Model {
	function authenticate($model,$username,$password){
		if($model=="Admin")
			$someone = $this->find("username ='$username'");
		else
			$someone = $this->find("email ='$username'");
        if(!empty($someone[$model]['password']) && $someone[$model]['password'] == md5($password))
        {
        	$this->id = $someone[$model]['id'];
        	if($model=="Admin")
				$this->saveField('lastloginold',$this->getValue($model,$someone[$model]['id'],"lastlogin"));
			$this->saveField('lastlogin',date("Y-m-d H:i:s", strtotime("now")));
			return $someone[$model];
        }
        else{ // Else, they supplied incorrect data.
        	return false;
        }
	}
	function checkIfExist($key,$value){
		if($this->hasAny("$key='$value'"))
			return true;
		else 
			return false;
	}
	public function bindParams($type,$name,$className,$cond="",$order="",$fields="",$foreignKey){
		$this->bindModel(
		        array($type => array($name =>
		                        array('className'    => $className,
		                              'conditions'   => $cond,
		                              'order'        => $order,
		                              'dependent'    =>  false,
		                              'fields'		 => $fields,
		                              'foreignKey'   => $foreignKey
		                        )
		        )
		    ));	
	}
	function getValue($model,$id,$field){
		if($data=$this->findById($id,"id,$field"))
			return $data[$model][$field];
		else
			return false;
	}
	function setAfterFind($results){
		//Convert the results to objects
		$resultObjects = Set::map( $results );
		foreach ( $resultObjects as &$item )
		{
			// Set _explicitType for all objects,
			// for correct mapping the object in flex
			if(is_object($this->name))
				$item->_explicitType = $this->name;
			// We does not need the _name_ property, which is set automatically
			// by the Set::Map() function when we use it without a class name
			unset ( $item->_name_ );
			
		}
		//print_r($resultObjects);
		return $resultObjects;		
	}
}
?>
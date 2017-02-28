<?php
class QuatroHelper extends Helper
{
	var $helpers = array('Form');
	function makeText($fieldName, $options = array()){
		$return = "";
		if(isset($options['labelClass']) and isset($options['labelName'])){
			$return  .= $this->addText($options['labelName'],$options['labelClass'],$options['labelFor']);
		}
		$options['label'] = false;
		$options['div'] = false;
		$options['type'] = 'text';
		$return .= '<div class="'.$options['inputClass'].'">';
		unset($options['labelName']);
		unset($options['labelClass']);
		unset($options['inputClass']);
		unset($options['labelFor']);
		
			$return .= '<span>';
				if(isset($options['password']) and $options['password']==true)
					$return .= $this->Form->password($fieldName,$options);
				else
					$return .= $this->Form->input($fieldName,$options);
			$return .= '</span>';
		$return .= '</div>';
        return $this->output($return);
	}
    function makeTimestamp($fieldName, $options = array()){
    	$return = "";
    	$explode = explode(".",$fieldName);
    	$idOfInput = "'".$explode[0].Inflector::camelize($explode[1])."'";
		$format = "'dd-mm-yyyy'";
    	if(isset($options['labelClass']) and isset($options['labelName'])){
			$return  .= $this->addText($options['labelName'],$options['labelClass'],$options['labelFor']);
		}
		$options['label'] = false;
		$options['div'] = false;
		$options['type'] = 'text';
		$return .= '<div class="'.$options['inputClass'].'">';
			$return .= '<div class="right">';
					$return .= $this->Form->input($fieldName,$options);
			$return .= '</div>';
			$return .= '<div class="right" style="margin-right:2px;"><div onclick="displayCalendar($('.$idOfInput.'),'.$format.',this)" class="bdashboard" /></div></div>';
		$return .= '</div>';
		$return .= '<div class="both"></div>';
        return $this->output($return);
    }
    function makeSelect($fieldName, $options = array()){
    	$explode = explode(".",$fieldName);
    	if(isset($this->data[$explode[0]][$explode[1]]))
    		$selvalue = $this->data[$explode[0]][$explode[1]];
    	else 
    		$selvalue = "";
    	$return = "";
		if(isset($options['labelClass']) and isset($options['labelName'])){
			$return  .= $this->addText($options['labelName'],$options['labelClass'],$options['labelFor']);
		}
		$return .= '<div class="'.$options['inputClass'].'">';
			$return .= '<span>';
				$return .= $this->Form->select($fieldName,$options['value'],$selvalue,array("empty"=>$options['empty']));
			$return .= '</span>';
		$return .= '</div>';
        return $this->output($return);
    }
    function makeTextArea($fieldName, $options = array()){
		$return = "";
		if(isset($options['labelClass']) and isset($options['labelName'])){
			$return  .= $this->addText($options['labelName'],$options['labelClass'],$options['labelFor']);
		}
		$return .= '<div class="'.$options['inputClass'].'">';
		unset($options['labelName']);
		unset($options['labelClass']);
		unset($options['inputClass']);
		unset($options['labelFor']);
			$return .= '<span>';
				$return .= $this->Form->textarea("$fieldName",$options);
			$return .= '</span>';
		$return .= '</div>';
		return $this->output($return);
	}
    function makeFile($fieldName, $options = array()){
    	$return = "";
		if(isset($options['labelClass']) and isset($options['labelName'])){
			$return  .= $this->addText($options['labelName'],$options['labelClass'],$options['labelFor']);
		}
		$return .= '<div class="'.$options['inputClass'].'">';
			$return .= '<span>';
				$return .= $this->Form->file("$fieldName");
			$return .= '</span>';
		$return .= '</div>';
        return $this->output($return);
    }
    function addText($title,$class,$labelfor=""){
    	$return  = '<div class="'.$class.'">';
		$return .= '<label for="'.$labelfor.'">'.$title.'</label>';
		$return .= '</div>';
		return $return;
    }
}
?>
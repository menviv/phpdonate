<?php 
	if(isset($value['row_class']))
		$class = $value['row_class'];
	else 
		$class = "row_newData";
	if(isset($RequireFields[$key]) and $RequireFields[$key]=="true")
		$requireClass = " requireClass";
	else 
		$requireClass = "";
	if(isset($stageclass) and !empty($stageclass))
		$class = $class." ".$stageclass;
?>
<div class="<?php echo $class;if($toggle=="true") echo " toggle";?>"<?php if($toggle=="true") echo " style='display:none;'"?>>
	<?php 
		switch ($key){
			case "password":
				echo $quatro->makeText("$model.$key",array("labelClass"=>"left names".$requireClass,"labelName"=>$value['name'],"labelFor"=>$model.inflector::camelize($key),"inputClass"=>"left inputs rtl","password"=>true));
				echo '</div><div class="row_newData">';
				echo $quatro->makeText("$model.passwordconfirm",array("labelClass"=>"left names".$requireClass,"labelName"=>"אימות סיסמא","labelFor"=>$model.inflector::camelize("passwordconfirm"),"inputClass"=>"left inputs rtl","password"=>true));
				break;
			default:
				$keyToCheck = Inflector::camelize($key);
				if(isset($$keyToCheck) and !empty($$keyToCheck)){
					echo $quatro->makeSelect("$model.$key",array("labelClass"=>"left names".$requireClass,"labelName"=>$value['name'],"labelFor"=>$model.inflector::camelize($key),"inputClass"=>"left inputs rtl","empty"=>true,"value"=>$$keyToCheck));
				}
				else{
					if(isset($value['type'])){
						switch ($value['type']){
							case "notAccesable":
								if(isset($editData))
									echo $quatro->makeText("$model.$key",array("labelClass"=>"left names","labelName"=>$value['name'],"labelFor"=>$model.inflector::camelize($key),"inputClass"=>"left inputs rtl","disabled"=>"disabled"));
								else 
									echo $quatro->makeText("$model.$key",array("labelClass"=>"left names","labelName"=>$value['name'],"labelFor"=>$model.inflector::camelize($key),"inputClass"=>"left inputs rtl"));
								break;
							case "date":
							//	echo $quatro->makeTimestamp("$model.$key",array("labelClass"=>"left names".$requireClass,"labelName"=>$value['name'],"labelFor"=>$model.inflector::camelize($key),"inputClass"=>"left inputs inputstimestamp rtl"));
								echo $quatro->makeTimestamp("$model.$key",array("labelClass"=>"left names".$requireClass,"labelName"=>$value['name'],"labelFor"=>$model.inflector::camelize($key),"inputClass"=>"left inputs inputstimestamp rtl"));
								break;
							case "dateMonth":
								if(isset($this->data['Article']['date_of_article']) and !empty($this->data['Article']['date_of_article'])){
									$monthSelected = date("m",strtotime($this->data['Article']['date_of_article']));
									$yearSelected = date("Y",strtotime($this->data['Article']['date_of_article']));
								}else{
									$monthSelected = date("m",strtotime("now"));
									$yearSelected = date("Y",strtotime("now"));
								}
								$monthsNames = array(1=>"ינואר",2=>"פברואר",3=>"מרץ",4=>"אפריל",5=>"מאי",6=>"יוני",7=>"יולי",8=>"אוגוסט",9=>"ספטמבר",10=>"אוקטובר",11=>"נובמבר",12=>"דצמבר");
								echo $quatro->addText($value['name'],"left names".$requireClass,$model.inflector::camelize($key));
								echo "<div class='left inputs'>".$form->select("$model.month",$monthsNames,$monthSelected,array("empty"=>false))."</div>";
								echo "<div class='left inputs'>".$form->year("$model.year",date("Y",strtotime("now"))-20,date("Y",strtotime("now")),$yearSelected,array("empty"=>false))."</div>";
								break;
							case "file":
								$deleteBrowse = "deleteBrowse('".$model.$keyToCheck."')";
								echo $quatro->makeFile("$model.$key",array("labelClass"=>"left names".$requireClass,"labelName"=>$value['name'],"labelFor"=>$model.inflector::camelize($key),"inputClass"=>"left inputs rtl"));
								echo "<div class='left' style='margin:7px 10px 0 10px;'><a href='javascript:void(0);' onclick=$deleteBrowse>".$html->image("/admin/img/icons/application_edit.png")."</a></div>";
								if(isset($editData) and isset($fileSrcKey[$model]) and in_array($key,$fileSrcKey[$model]) and !empty($this->data[$model][$key])){
									$deleteFile = "deleteFile('$model','$key','$editDataId')";
									echo "<div id='openFileBrowse".$model.$key."' class='left' style='margin:7px 0 0 10px;'><a href='".$html->url("/img/".$fileSrc[$model]."/".$this->data[$model][$key])."' target='_blank'>".$html->image("/admin/img/icons/application_link.png")."</a></div>";
									echo "<div id='deleteFileBrowse".$model.$key."' class='left' style='margin:7px 0 0;'><a href='javascript:void(0);' onclick=$deleteFile>".$html->image("/admin/img/icons/application_delete.png")."</a></div>";
								}
								break;
							case "link":
								echo $quatro->addText($value['name'],"left names".$requireClass,$model.inflector::camelize($key));
								$link = "http://".$_SERVER['HTTP_HOST'].$this->base."/";
								$link .= isset($startLink) ? $startLink : "";
								if(isset($site_direction) and $site_direction=="rtl"){
									echo $quatro->makeText("$model.$key",array("inputClass"=>"left inputs rtl linkInput"));
									echo "<div class='left' style='margin:9px 5px 0 10px;direction:ltr;color:#9a9a9a;'>$link</div>";
								}else{
									echo "<div class='left' style='margin:9px 5px 0 10px;direction:ltr;color:#9a9a9a;'>$link</div>";
									echo $quatro->makeText("$model.$key",array("inputClass"=>"left inputs rtl linkInput"));
								}
								break;
							case "text":
								echo $quatro->makeTextArea("$model.$key",array("labelClass"=>"left names".$requireClass,"labelName"=>$value['name'],"labelFor"=>$model.inflector::camelize($key),"inputClass"=>"left inputs rtl","class"=>isset($value['class']) ? $value['class'] : null));
								break;
							default:
								if(isset($selects[$keyToCheck])){
									echo $quatro->makeSelect("$model.$key",array("labelClass"=>"left names".$requireClass,"labelName"=>$value['name'],"labelFor"=>$model.inflector::camelize($key),"inputClass"=>"left inputs rtl","empty"=>true,"value"=>$selects[$keyToCheck]));
								}
								else
									echo $quatro->makeText("$model.$key",array("labelClass"=>"left names".$requireClass,"labelName"=>$value['name'],"labelFor"=>$model.inflector::camelize($key),"inputClass"=>"left inputs rtl"));
						}
					}
					else{
						if(isset($selects[$keyToCheck])){
							$empty = true;
							if(isset($selects[$keyToCheck]['empty'])){
								if($selects[$keyToCheck]['empty']=="false"){
									$empty = false;
								}
								unset($selects[$keyToCheck]['empty']);
							}
							echo $quatro->makeSelect("$model.$key",array("labelClass"=>"left names".$requireClass,"labelName"=>$value['name'],"labelFor"=>$model.inflector::camelize($key),"inputClass"=>"left inputs rtl","empty"=>$empty,"value"=>$selects[$keyToCheck]));
						}else{
							echo $quatro->makeText("$model.$key",array("labelClass"=>"left names".$requireClass,"labelName"=>$value['name'],"labelFor"=>$model.inflector::camelize($key),"inputClass"=>"left inputs rtl"));
						}
					}
				}
		}
	?>
	<div class="both"></div>
</div>
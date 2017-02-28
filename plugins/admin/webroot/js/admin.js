function showToolTip(type,tooltiptype){
	$("tooltipicon").className = "left tooltipicon"+tooltiptype;
	$("tooltiptext").innerHTML = toolTipTexts[type];
	$("tooltip").className = "tooltip"+tooltiptype;
	$("tooltip").style.display="block";
}
function sendAjaxForm(ajaxAction,ajaxData){
	new Ajax.Request(ajaxAction, {
		method: 'post',
		postBody: ajaxData,
		onComplete: function(resp) {
			txt = resp.responseText;
			return txt;
		}
	});
}
function sendLoginForm(evt) {
	Event.stop(evt);
	formData = $('loginform').serialize();
	new Ajax.Request($('loginform').action, {
		method: 'post',
		postBody: formData,
		onComplete: function(resp) {
			txt = resp.responseText;
			switch(txt){
				case "Error":
					$('formError').innerHTML="* Error: inncorrect login details";
				break;
			case "Fine":
				//Login sucssesfull
				window.location = (url);
				break;
			}
		}
	});
}
function orderByData(field){
	perpage = gup("perpage");
	if(lastField==field){
		if(orderType=="asc")
			orderType = "desc";
		else
			orderType = "asc";
	}
	else
		orderType = "asc";
	if(typeof(searchVar)=="undefined")
		searchVar = "";
	new Ajax.Request(orderUrl+"?orderby="+field+"&ordertype="+orderType+"&"+searchVar+"&perpage="+perpage, {
		onComplete: function(resp) {
			txt = resp.responseText;
			$("listData").innerHTML = txt;
		}
	});
	lastField = field;
}
function gup(name){
	name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp( regexS );
	var results = regex.exec( window.location.href );
	if( results == null )
		return "";
	else
		return results[1];
}
function sendNewDataForm(evt,preview){
	if(tinyMCE!='')
		tinyMCE.triggerSave();
	if(evt!='')
		Event.stop(evt);
	formData = $('newDataForm').serialize();
	urlToSend = $('newDataForm').action;
	if(preview!=''){
		urlToSend = $('newDataForm').action+"?preview=true";
	}
	returnFlag = false;
	new Ajax.Request(urlToSend, {
		method: 'post',
		postBody: formData,
		onComplete: function(resp) {
			txt = resp.responseText;
			switch(txt){
				case "Require":
					if(tinyMCE!='')
						tinyMCE.execCommand('mceAddControl', false);
					showToolTip("require","error");
				break;
				case "Error":
					showToolTip("error","error");
				break;
				case "Passwords Mismatch":
					showToolTip("passwordsmismatch","error");
				break;
				case "Edited":
					showToolTip("edited","ok");
					window.location = (AjaxUrl);
				break;
				case "Added":
					showToolTip("added","ok");
					//if(preview!=''){
					//	returnFlag = true;
					//}else{
						window.location = (AjaxUrl);
					//}
				break;
			}
		}
	});
	//alert("here");
	if(returnFlag == true){
		alert("here");
		return true;
	}
}
function deleteRow(id,model){
	if(confirm('Are you sure?')){
		new Ajax.Request(deleteUrl+model+"/delete/"+id, {
			method: 'post',
			onComplete: function(resp) {
				txt = resp.responseText;
				switch(txt){
					case "Deleted":
						new Effect.Fade("row_"+id);
						showToolTip("deleted","ok");
						break;
					case "Error":
						showToolTip("error","error");
						break;
				}
			}
		});
	}
}
function deleteBrowse(browse_id){
	$(browse_id).value = "";
}
function deleteFile(model,key,model_id){
	if(confirm('Are you sure?')){
		new Ajax.Request(deleteFileUrl+model+"/"+key+"/"+model_id, {
			method: 'post',
			onComplete: function(resp) {
				txt = resp.responseText;
				$("openFileBrowse"+model+key).remove();
				$("deleteFileBrowse"+model+key).remove();
			}
		});
	}
}
function openToggle(ele){
	divElement = ele.parentNode.parentNode;
	divId = $(divElement).identify();
	if($$("#"+divId+" .toggle")[0].style.display=="none")
		$$("#"+divId+" .toggle").invoke('show');
	else
		$$("#"+divId+" .toggle").invoke('hide');
}
function openAddItemPopup(isEdit){
	if(typeof(isEdit)=="undefined"){
		form_id = $$("#newItemPopUp form")[0].id;
		if($$(".hiddenId").length>0){
			hiddenId = $$(".hiddenId input")[0].id;
			$(hiddenId).value = "";
		}
		$(form_id).reset();
		if($("newdownloadType")){
			$("newdownloadLevel1discount").value = discountlevels[1];
			$("newdownloadLevel2discount").value = discountlevels[2];
			$("newdownloadLevel3discount").value = discountlevels[3];
		}
	}
	if($("newdownloadType"))
		changeDownloadType();
	$("bgblackposition").style.display = "block";
	$("newItemPopUpContainer").style.display = "block";
}
function closeItemPopup(){
	$("bgblackposition").style.display = "none";
	$("newItemPopUpContainer").style.display = "none";		
}
function movePos(action,idOfModel){
	$("row_"+idOfModel).removeClassName("listTdOver");
	switch(action){
		case "up":
			if(!$("row_"+idOfModel).previousSiblings()[0])
				return;
			rowId = $("row_"+idOfModel).previousSiblings()[0];
			$("row_"+idOfModel).select("input")[0].value = parseInt($("row_"+idOfModel).select("input")[0].value)-1;
			$("row_"+idOfModel).select(".orderIconDown a")[0].style.display = "block";
			//rowId.select("input")[0].value = parseInt($("row_"+idOfModel).select("input")[0].value)+1;
			$(rowId).insert({
				before: $("row_"+idOfModel)
			});
			break;
		case "down":
			if(!$("row_"+idOfModel).nextSiblings()[0])
				return;
			rowId = $("row_"+idOfModel).nextSiblings()[0];
			$("row_"+idOfModel).select("input")[0].value = parseInt($("row_"+idOfModel).select("input")[0].value)+1;
			$("row_"+idOfModel).select(".orderIconUp a")[0].style.display = "block";
			rowId.select("input")[0].value = parseInt($("row_"+idOfModel).select("input")[0].value)-1;
			$(rowId).insert({
				after: $("row_"+idOfModel)
			});
			break;
	}
	//alert(Sortable.serialize('listtablelistbody'));
}
function sendPositionUpdate(){
	var list = new Object();
	$$(".listrowlist").each(function(ele){
		list[ele.id] = $(ele).select(".orderInput input")[0].value;
	});
	list = Object.toJSON(list);
	new Ajax.Request(sorturl , {
		method: "post",
		parameters: {data:list}
	});
}
function loadAjax(){
	new Ajax.Request(homeUrl+"admin/changeAjax/"+model+"/"+this.id+"/"+this.value, {
		method: 'post',
		onComplete: function(resp) {
			txt = resp.responseText;
		}
	});
}
function previewItem(){
	//alert(sendNewDataForm("","true"));
	return;
	if(sendNewDataForm("","true")==true){
		alert("ok");
	}
}
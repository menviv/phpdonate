function openinner(id){
	$("sidemenuiconopen"+id).style.display="none";
	$("sidemenutitle"+id).addClassName("sidemenutitlecurrent");
	$("sidemenuinnercontainer"+id).style.display="block";
}
function closeinner(id){
	$("sidemenuiconopen"+id).style.display="block";
	$("sidemenutitle"+id).removeClassName("sidemenutitlecurrent");
	$("sidemenuinnercontainer"+id).style.display="none";
}
function changeInner(id){
	if($("sidemenuinnercontainer"+id).style.display=="block")
		closeinner(id);
	else
		openinner(id);
}
function createSort(){
	Sortable.create('listtablelistbody',{
		tag:'tr',
		only:'listrowlist',
		handle:'listhandle',
		dropOnEmpty:true, 
		containment: ["listtablelistbody"],
		onChange:function(){
			$$("tr.listrowlist").invoke("stopObserving");
		},
		onUpdate: function() {
			new Ajax.Request(sorturl , {
				method: "post",
				parameters: {data:Sortable.serialize('listtablelistbody')}
			});
            	$$("tr.listrowlist").invoke('observe', 'mouseover', function(ele){this.addClassName("listTdOver");});
			$$("tr.listrowlist").invoke('observe', 'mouseout', function(ele){this.removeClassName("listTdOver");});
		}
	});
}
function enableuser(user_id){
	new Ajax.Request(adminUrlAction+"/enableUser/"+user_id, {
		onComplete: function(resp) {
			$('userenableonline'+user_id).style.display = "inline";
			$('userenableoffline'+user_id).style.display = "none";
		}
	});
}
function disableuser(user_id){
	if(confirm('Are You Sure?')){
		new Ajax.Request(adminUrlAction+"/disableUser/"+user_id, {
			onComplete: function(resp) {
				$('userenableonline'+user_id).style.display = "none";
				$('userenableoffline'+user_id).style.display = "inline";
			}
		});
	}
}
function verify(model,row_id,type){
	if(type=="false"){
		if(!confirm('Are you sure?'))
			return
	}
	new Ajax.Request(adminUrlAction+"/verify/"+model+"/"+row_id+"/"+type, {
		onComplete: function(resp) {
			$('verifytrue'+row_id).style.display = "none";
			$('verifyfalse'+row_id).style.display = "none";
			if(type=="false")
				$("row_"+row_id).addClassName("row_list_red");
			else
				$("row_"+row_id).addClassName("row_list_green");
		}
	});
}
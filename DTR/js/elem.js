function check(node, pad){
	const checkbox = document.querySelectorAll("input[type='checkbox']");
	for(var i=0;i< checkbox.length; i++){
		if(checkbox[i]==node){
			const parent = checkbox[i].parentElement.parentElement;
			if(checkbox[i].checked){
				if(parent.childNodes[6+pad].childNodes[0].value!="")
					parent.childNodes[7+pad].childNodes[0].readOnly=true;
				
				parent.childNodes[6+pad].childNodes[0].readOnly=true;
				parent.childNodes[6+pad].childNodes[0].required=false;
				parent.childNodes[7+pad].childNodes[0].required=false;
			}else{
				if(parent.childNodes[6+pad].childNodes[0].value!="")
					parent.childNodes[7+pad].childNodes[0].readOnly=false;
				
				parent.childNodes[6+pad].childNodes[0].readOnly=false;
				parent.childNodes[6+pad].childNodes[0].required=true;
				parent.childNodes[7+pad].childNodes[0].required=true;
			}
			
		}
	}
}
function dis(node,pad){
	const radios = document.querySelectorAll("input[type='radio']");
	const checkbox = document.querySelectorAll("input[type='checkbox']");
	for(var i=0; i<radios.length; i++){
		const parent = radios[i].parentElement.parentElement;
		if(radios[i]==node){
			parent.childNodes[2+pad].childNodes[0].setAttribute("onclick", "return false;");
			parent.childNodes[6+pad].childNodes[0].readOnly=true;
			parent.childNodes[7+pad].childNodes[0].readOnly=true;	
			parent.childNodes[6+pad].childNodes[0].required=false;
			parent.childNodes[7+pad].childNodes[0].required=false;			
		}else{
			parent.childNodes[2+pad].childNodes[0].removeAttribute("onclick");
			parent.childNodes[6+pad].childNodes[0].readOnly=false;
			parent.childNodes[6+pad].childNodes[0].required=true;
			parent.childNodes[7+pad].childNodes[0].required=true;

			if(parent.childNodes[6+pad].childNodes[0].value!="")
				parent.childNodes[7+pad].childNodes[0].readOnly=false;

			if(checkbox[i].checked){
				parent.childNodes[6+pad].childNodes[0].readOnly=true;
				parent.childNodes[7+pad].childNodes[0].readOnly=true;
				parent.childNodes[6+pad].childNodes[0].required=false;
				parent.childNodes[7+pad].childNodes[0].required=false;
			}
		}
	}
}

function timed(node){
	var start = document.querySelectorAll("input[name='in[]']");
	for(var i=0; i<start.length; i++){
		if(node==start[i]){
			const end = document.querySelectorAll("input[name='out[]']");
			if(start[i].value>='07:00' && start[i].value<='09:00'){
				end[i].readOnly=false;
				end[i].value=null;
			}else{
				alert("Please choose an in-time between 7am and 9am(inclusively)");
				start[i].value=null;
				end[i].readOnly=true;
				end[i].value=null;
			}
		}
	}
}
function ended(node){
	var end = document.querySelectorAll("input[name='out[]']");
	for(var i=0; i<end.length; i++){
		if(node==end[i]){
			const start = document.querySelectorAll("input[name='in[]']");
			if(!computeTime(start[i].value, end[i].value)){
				alert("Please choose an appropriate end-time");
				end[i].value=null;
			}
		}
	}
}
function computeTime(start, end){
	var startHour = parseInt(start.substring(0,2));
	var startMin = parseInt(start.substring(3,5));
	var endHour = parseInt(end.substring(0,2));
	var endMin = parseInt(end.substring(3,5));

	startMin+=startHour*60;
	endMin+=endHour*60;
	var total =  endMin-startMin;
	return total>=420 && total<=840;
}
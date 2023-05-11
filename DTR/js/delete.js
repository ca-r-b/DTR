const monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
const date = document.querySelector("input[name='date']");
const week = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
date.addEventListener("change", function(){
	if(date.value!=""){
		const d = new Date(date.value);
		d.setDate(d.getDate() -d.getDay());
		document.querySelector(".parent").innerHTML="";
		for(var i=1; i<7; i++){
			d.setDate(d.getDate() +1);
			var dy=d.getFullYear()+"-"+("0"+(d.getMonth()+1)).slice(-2)+"-"+("0"+(d.getDate())).slice(-2);
			document.querySelector(".parent").innerHTML+="<input type='text' value="+dy+" name='dates[]' readOnly>";
		}
	}else{
		document.querySelector(".parent").innerHTML="";
	}
});
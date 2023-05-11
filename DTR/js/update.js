const monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
const week = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
const date=document.querySelector("input[name='i_date']");
date.addEventListener("change", function(){
		var d = new Date(date.value);
		d.setDate(d.getDate()-d.getDay()+1);
		var sd = document.createElement("input");
		sd.setAttribute("name","startDate");
		sd.setAttribute("type","hidden");
		sd.setAttribute("value",d.getFullYear()+'-'+("0"+(d.getMonth()+1)).slice(-2)+"-"+("0"+d.getDate()).slice(-2));
		var ed = document.createElement("input");
		ed.setAttribute("name","endDate");
		ed.setAttribute("type","hidden");
		d.setDate(d.getDate()+5);
		ed.setAttribute("value",d.getFullYear()+'-'+("0"+(d.getMonth()+1)).slice(-2)+"-"+("0"+d.getDate()).slice(-2));
		document.querySelector("form").append(sd);
		document.querySelector("form").append(ed);
		document.querySelector("#invi").click();	
		document.querySelector("input[type='radio']").required=true;
});

if(document.querySelectorAll(".parent").length!=0){
	for(var i=1; i<7; i++){
		var rest =document.querySelector(".r"+i);
		rest.addEventListener("change", function(event){
			dis(event.target, 0);
		});
		var present =document.querySelector(".cb"+i);
		present.addEventListener("change", function(event){
			check(event.target, 0);
		});
		var start =document.querySelector(".in"+i);
		start.addEventListener("change", function(event){
			timed(event.target);
		});
		var end = document.querySelector(".out"+i);
		end.addEventListener("change", function(event){
			ended(event.target);
		});
	}
	if(document.querySelector("input[name='submit']")==null){
		const submit = document.createElement("input");
		submit.setAttribute("type", "submit");
		submit.setAttribute("name", "submit");
		document.querySelector("form").append(submit);
	}
}else{
	if(document.querySelector("input[name='submit']")!=null){
		document.querySelector("input[name='submit']").remove();	
		const parents = document.querySelectorAll(".parent");
		for(var i=0; i< parents.length; i++){
			parents[i].innerHTML="";
		}
	}
}

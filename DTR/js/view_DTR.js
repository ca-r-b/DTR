const monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
	const monthVal = document.querySelector("input#month");
	const month = document.querySelector("input[type='month']");
	if(monthVal!=null){
		const d = new Date(monthVal.value.substring(0,4)+"-"+monthVal.value.substring(5)+"-01");
		document.querySelector(".day").innerHTML=monthNames[d.getMonth()]+"-"+d.getFullYear();
		const amount=daysInMonth(d.getMonth(),d.getFullYear());
		const start=d.getDay();
		var i;
		for(i=1; i<42; i++){
			document.querySelector(".day-"+i+"-date").innerHTML="";
			document.querySelector(".day-"+i+"-in").innerHTML="";
			document.querySelector(".day-"+i+"-out").innerHTML="";
			document.querySelector(".day-"+i+"-event").innerHTML="";
		}
		for(i=1; i<=amount; i++){
			document.querySelector(".day-"+(start+i)+"-date").innerHTML=i;
			var dd = document.querySelector(".d"+i);
			if(dd!=null){
				document.querySelector(".day-"+(start+i)).classList.add(dd.querySelector(".attendance").value=="Present" ? "t-present": "t-absent");
				console.log("rest"+dd.querySelector(".restday").value==1);
				console.log("event"+dd.querySelector(".event").value!="");
				document.querySelector(".day-"+(start+i)).classList.add((dd.querySelector(".restday").value==1 || dd.querySelector(".event").value!="") ? (dd.querySelector(".attendance").value=="Present" ? "t-extra": "t-rest") : "no-add");

				document.querySelector(".day-"+(start+i)+"-in").innerHTML="In: " + dd.querySelector(".timein").value;
				document.querySelector(".day-"+(start+i)+"-out").innerHTML="Out: " + dd.querySelector(".timeout").value;
				var event = dd.querySelector(".event").value;
				document.querySelector(".day-"+(start+i)+"-event").innerHTML="Holiday: "+(event!=""?event:"---");
			}
		}
	}
	month.addEventListener("change", function(){
		document.querySelector("input[name='invi']").click();
	});
	
	function daysInMonth (month, year) { return (new Date (year, month+1, 0)).getDate (); }
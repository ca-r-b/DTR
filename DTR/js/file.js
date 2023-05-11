const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
const date = document.querySelector("input[type='date']");
const week = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
date.addEventListener("change", function() {
	const d = new Date(date.value);
	if(date.value!=''){
		d.setDate(d.getDate() - d.getDay());

		for (var i = 1; i <= 6; i++)
			if (document.querySelector(".day" + i) != null)
				document.querySelector(".day" + i).remove();

		for (var i = 1; i <= 6; i++) {
			const parent = document.createElement("div");
			parent.classList.add("parent", "day" + i);
			document.querySelector("form").insertBefore(parent, document.querySelector(".xml"));
		}
		for (var i = 1; i < 7; i++) {
			d.setDate(d.getDate() + 1);
			var dy = d.getFullYear() + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" + ("0" + (d.getDate())).slice(-2);
			const day = document.querySelector(".day" + i);
			day.innerHTML = "<input type='hidden' value=" + dy + " name='date[]'>";
			day.innerHTML += "<div class='div1'><input type='radio' class='r" + i + "' name='rest' value=" + i + "></div>";
			day.innerHTML += "<div class='div2'>Date: " + monthNames[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear() + "</div>";
			day.innerHTML += "<div class='div3'><input class='cb" + i + "' name='absent" + i + "' type='checkbox' value='absent'>Absent</div>";
			day.innerHTML += "<div class='div4'>Time</div>";
			day.innerHTML += "<div class='div5'>IN</div>";
			day.innerHTML += "<div class='div6'>OUT</div>";
			day.innerHTML += "<div class='div7'><input type='time' class='in" + i + "' name='in[]' required></div>";
			day.innerHTML += "<div class='div8'><input type='time' class='out" + i + "' name='out[]' required readOnly></div>";
			day.innerHTML += "<div class='div9'>" + week[i] + "</div>";
			var rest = document.querySelector(".r" + i);

			rest.addEventListener("click", function(event) {
				dis(event.target, 1);
			});
			var present = document.querySelector(".cb" + i);
			present.addEventListener("change", function(event) {
				check(event.target, 1);
			});
			var start = document.querySelector(".in" + i);

			start.addEventListener("change", function(event) {
				timed(event.target);
			});
			var end = document.querySelector(".out" + i);

			end.addEventListener("change", function(event) {
				ended(event.target);
			});
		}
		document.querySelector("input[type='radio']").required = true;
	}else{
		const parents = document.querySelectorAll(".parent");
		for(var i=0; i< parents.length; i++){
			parents[i].innerHTML="";
		}
	}
	
});

const submit = document.querySelector("input[type='submit']");
submit.addEventListener("click", function() {
	const file = document.querySelector("input[type='file']");
	if(file.value==''){
		date.required = true;
		submit.setAttribute("formaction", "process/insert.php");
	}else{
		date.required = false;
		submit.setAttribute("formaction", "../dtrFileXML.php");
	}
});
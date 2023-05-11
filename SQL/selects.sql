SELECT * 
FROM 	dtr d 
		LEFT JOIN calendar c ON 
		month(d.date) = month(c.date) AND 
		day(d.date) = day(c.date) 
WHERE month(d.date)=<month> and 
	  year(d.date)=<year> and 
	  user_id=<user_id> 
order by d.date; 
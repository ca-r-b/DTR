SELECT SUM(netSalary) as totalSalary
FROM(
	SELECT	user_ID,
			position,
			dayAttendance,
			dates,
			netHoursRendered-((netHoursRendered MOD 8) * FLOOR(netHoursRendered/8)) AS hoursRendered,
			salary * netHoursRendered-((netHoursRendered MOD 8) * FLOOR(netHoursRendered/8)) AS salary,
			((netHoursRendered MOD 8) * FLOOR(netHoursRendered/8)) AS OTHours,
			((netHoursRendered MOD 8) * FLOOR(netHoursRendered/8)) * OT AS OTSalary,
			(((netHoursRendered MOD 8) * FLOOR(netHoursRendered/8)) * OT)+(salary * netHoursRendered-((netHoursRendered MOD 8) * FLOOR(netHoursRendered/8))) AS netSalary,
			netHoursRendered,
			rest
	FROM (
		SELECT 	d.user_ID AS user_ID, 
				p.position AS position, 
				d.dayAttendance AS dayAttendance, 
				d.date AS dates,
				p.salary AS salary,
				p.OT as OT,
				d.is_restday as rest,
				FLOOR((d.timeout-d.timein)/10000) - 1 + ((d.is_restday OR event IS NOT null)*7) as netHoursRendered
		FROM dtr d JOIN users u ON d.user_ID = u.user_ID
		JOIN position p ON u.position_ID = p.position_ID
		LEFT JOIN calendar c ON d.date = c.date
		WHERE event IS NOT null OR is_restday = 1 OR d.dayAttendance='Present'
	) as x
) as t;
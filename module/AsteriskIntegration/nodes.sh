#!/bin/bash
sleep 30
cd /var/www/html/suitecrm
while true;
do
	chksrv1=`ps aux | grep "[n]ode modules/AsteriskIntegration/server.js 5188 52.3.196.3 5038" | awk '{print$2}'`
	if [ ! -n "$chksrv1" ];
	then
		echo -e "5188 process not running, starting the process"
		bash modules/AsteriskIntegration/server_start.sh '5188' '52.3.196.3' '5038' 'sugarcrm' 'ba96275427f0155cdf0627b8d0ddac8e' 'http://ec2-52-3-196-3.compute-1.amazonaws.com' '80' &
	fi
	sleep 10
done

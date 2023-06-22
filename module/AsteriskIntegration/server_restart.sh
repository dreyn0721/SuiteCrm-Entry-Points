if [ "$#" -eq 7 ]
then
	pid=`ps aux | grep "[m]odules/AsteriskIntegration/server.js $1 $2 $3" | awk '{print$2}'`
	kill -9 $pid
	nohup node modules/AsteriskIntegration/server.js "$1" "$2" "$3" "$4" "$5" "$6" "$7" </dev/null &>/dev/null &
fi
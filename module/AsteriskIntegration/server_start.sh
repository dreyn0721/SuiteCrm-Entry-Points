if [ "$#" -eq 7 ]
then
	nohup node modules/AsteriskIntegration/server.js "$1" "$2" "$3" "$4" "$5" "$6" "$7" </dev/null &>/dev/null &
fi
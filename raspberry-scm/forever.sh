#!/bin/bash
#############################################################
# Ensure the PID is always present, that way we are sure    #
# The process didn't die.                                   #
#############################################################
# Command to ensure we're running (This call should create the file with the PID...)
CMD='/usr/share/nginx/html/raspberry-scm/command.php cron'

# Location of the file with the PID inside.
PIDLOC='/mnt/pendrive/raspi-scm.pid'

# Every how long to checks
SECONDS=60

############################################
# Main program, we're going to call...     #
############################################
while true; do
  PID=$(<$PIDLOC)
    if ps -p $PID > /dev/null; then
        echo "$PID is running"
    else
        php7.0 $CMD > /dev/null &disown
        echo "Wasn't running on $PID"
    fi
  echo "Sleeping $SECONDS"
  sleep $SECONDS
done

#!/bin/bash

DATE=`date "+%Y-%m-%d"`
LOG='../updater.log'
USER='www-data'
DIR_MAKE='raspberry-scm/assets raspberry-scm/protected/assets raspberry-scm/protected/runtime'
PERMISSION='755'

echo " Starting Updater... "
echo ""
echo ""
# fetch changes, git stores them in FETCH_HEAD
git fetch
echo "Fetch completed."
# check for remote changes in origin repository
new_updates_available=`git diff HEAD FETCH_HEAD`
if [ "$new_updates_available" != "" ]
then
        echo "Creating fallback branch"
		git stash
		# create the fallback
        git branch fallbacks
        git checkout fallbacks
		
        git add .
        git add -u
        git commit -m "$DATE"
        echo "Fallback created" >> $LOG
 
        git checkout master
        git pop
		git pull
        git merge FETCH_HEAD --squash v1.0 -m "Automerging updates"
        echo "Merged updates" >> $LOG
        for branch in $(git for-each-ref --format '%(refname:short)' refs/heads/)
        do
            git merge-base --is-ancestor ${branch} HEAD -m "Automerging" && git branch -d ${branch}
        done
		mkdir -p $DIR_MAKE > /dev/null 2>&1
        chown $USER:$USER * -R > /dev/null 2>&1
        chmod $PERMISSION * -R > /dev/null 2>&1
else
        echo "No updates available" >> $LOG
fi
mkdir -p $DIR_MAKE > /dev/null 2>&1
chown $USER:$USER * -R > /dev/null 2>&1
chmod $PERMISSION * -R > /dev/null 2>&1

echo "Updater finished, you should be running the latest version..."
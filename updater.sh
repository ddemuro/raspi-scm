#!/bin/bash

DATE=`date "+%Y-%m-%d"`
LOG='../updater.log'
# fetch changes, git stores them in FETCH_HEAD
git fetch

# check for remote changes in origin repository
new_updates_available=`git diff HEAD FETCH_HEAD`
if [ "$new_updates_available" != "" ]
then
        # create the fallback
        git branch fallbacks
        git checkout fallbacks
 
        git add .
        git add -u
        git commit -m "$DATE"
        echo "fallback created" >> $LOG
 
        git checkout master
        git pull
        git merge FETCH_HEAD --squash v1.0
        echo "merged updates" >> $LOG
        for branch in $(git for-each-ref --format '%(refname:short)' refs/heads/)
        do
            git merge-base --is-ancestor ${branch} HEAD && git branch -d ${branch}
        done
		mkdir raspberry-scm/assets raspberry-scm/protected/assets raspberry-scm/protected/runtime 
        chown www-data:www-data * -R
        chmod 755 * -R
else
        echo "no updates available" >> $LOG
fi
mkdir raspberry-scm/assets raspberry-scm/protected/assets raspberry-scm/protected/runtime 
chown www-data:www-data * -R
chmod 755 * -R

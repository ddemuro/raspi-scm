#!/bin/bash

####################################
# Update script for raspberry scm. #
####################################
LOGGER="/tmp/updater.log"
URLVERSION="https://www.derekdemuro.com/versions/raspiscm.txt"
URLDOWNLOAD="https://www.derekdemuro.com/versions/raspiscm.zip"
OUTPUTLOCATION="/tmp/updater/"
UPDATEFILENAME="raspiscmver.txt"
CDNS1='8.8.8.8'
CDNS2='8.8.4.4'

# Check the version file exits
if [ ! -f "/var/$UPDATEFILENAME" ]; then
    echo "Missing local version... not continuing..."
    exit 1
fi

SYSTEMVERSION=$(</var/$UPDATEFILENAME)
echo "Updating raspi-scm system." >> $LOGGER
# Checking external version
ver=`curl $URLVERSION`
ver=${ver//$'\n'/} # Remove all newlines.
echo "Version on server: $ver" >> $LOGGER
echo "Version on system: $SYSTEMVERSION" >> $LOGGER

echo "Packages required for updater script." >> $LOGGER
apt-get install -qq --force-yes -y unzip rsync curl

if [[ "$SYSTEMVERSION" -lt "$ver" ]]; then
    # Crating temporal directory.
    echo "Crating temporal directory" >> $LOGGER
    mkdir -p $OUTPUTLOCATION
    mkdir -p $OUTPUTLOCATION/new

    # To avoid custom dns resolver issues. - 8.8.8.8 Google's Primary and 8.8.4.4 Google's secondary.
    wget -t 3 -T 5 -O "$OUTPUTLOCATION$UPDATEFILENAME" $URLDOWNLOAD ||
    curl --resolve $URLDOWNLOAD:$CDNS1 $URLDOWNLOAD -o "$OUTPUTLOCATION$UPDATEFILENAME" ||
    curl --resolve $URLDOWNLOAD:$CDNS2 $URLDOWNLOAD -o "$OUTPUTLOCATION$UPDATEFILENAME"

    # Unzip new version to updater location.
    unzip "$OUTPUTLOCATION$UPDATEFILENAME" -d $OUTPUTLOCATION/new >> $LOGGER

    if [ ! -f "$OUTPUTLOCATION/new/var/raspiscm.txt" ]; then
        echo "Missing version file in new version... ERROR!." >> $LOGGER
        rm -rf $OUTPUTLOCATION
        exit 1
    fi

    # Run updater scripts.
    chmod +x $OUTPUTLOCATION/new/preupdater.sh
    chmod +x $OUTPUTLOCATION/new/postupdater.sh
    # Before the system is synced
    $OUTPUTLOCATION/new/preupdater.sh >> $LOGGER
    # Sync system with update.
    rsync -avz $OUTPUTLOCATION/new /
    # After the new system has been synced
    $OUTPUTLOCATION/new/postupdater.sh >> $LOGGER

    # Removing updater script.
    rm /updater.sh
else
    echo "All up to date!."
fi
exit 0

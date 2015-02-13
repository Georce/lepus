#!/bin/bash

basedir=""

#check basedir
########################################################
if test -z "$basedir"
then
  basedir=/usr/local/lepus
else
  basedir="$basedir"
fi
echo "[note] lepus will be install on basedir: $basedir"

#create dir
#########################################################
if [ ! -x "$basedir" ]; then 
  echo "[note] $basedir directory does not exist,will be created."
  mkdir -p "$basedir"
  echo "[note] $basedir directory created success."
else
  echo "[error] $basedir directory already exists,install exit."
  exit
fi

#copy files
########################################################
echo "[note] wait copy files......."
cp -r * $basedir

#change chmod
########################################################
echo "[note] change script permission."
chmod +x $basedir/lepus*

#create links
########################################################
echo "[note] create links."
ln -s $basedir/lepus /usr/local/sbin/
ln -s $basedir/lepus_monitor /usr/local/sbin/
echo "[note] install complete."

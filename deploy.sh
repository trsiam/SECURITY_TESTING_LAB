#!/bin/bash

SOURCE="$(pwd)/"
DEST="/home/teamrabb/cybertestinglab.teamrabbil.com/"

rsync -av --delete \
  --exclude='.git/' \
  --exclude='.cpanel.yml' \
  --exclude='.well-known/' \
  --exclude='cgi-bin/' \
  --exclude='.htaccess' \
  --exclude='.user.ini' \
  --exclude='php.ini' \
  "$SOURCE" "$DEST"
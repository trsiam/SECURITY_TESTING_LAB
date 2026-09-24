#!/bin/bash

SOURCE="$(pwd)/"
DEST="/home/teamrabb/cybertestinglab/"

rsync -av --delete \
  --exclude='.git/' \
  --exclude='.cpanel.yml' \
  "$SOURCE" "$DEST"
#!/bin/bash

# Make us independent from working directory
pushd `dirname $0` > /dev/null
SCRIPT_DIR=`pwd`
popd > /dev/null

eval `ssh-agent`

if [ -f "$SCRIPT_DIR/docker-compose.local.yml" ]; then
  docker-compose -f "$SCRIPT_DIR/docker-compose.local.yml" down
else
  docker-compose -f "$SCRIPT_DIR/docker-compose.yml" down
fi

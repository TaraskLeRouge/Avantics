#!/bin/sh
set -e

uid=$(stat -c %u /srv)
gid=$(stat -c %g /srv)

# Change node's uid & guid to be the same as directory in host
sed -ie "s/`id -u node`:`id -g node`/$uid:$gid/g" /etc/passwd

chown -R node:node /srv

if [ $# -eq 0 ]; then
    yarn install && /bin/bash
else
    su node -s /bin/bash -c "$*"
fi
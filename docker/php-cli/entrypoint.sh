#!/bin/sh
set -e

uid=$(stat -c %u /srv)
gid=$(stat -c %g /srv)
user_name="www-data"
group_name="www-data"

if [ $uid = 0 ] && [ $gid = 0 ]; then
   if [ $# -ne 0 ]; then
       exec "$@"
   fi
fi

sed -i -r "s/$user_name:x:[[:digit:]]+:[[:digit:]]+:/$user_name:x:$uid:$gid:/g" /etc/passwd
sed -i -r "s/$group_name:x:[[:digit:]]+:/$group_name:x:$gid:/g" /etc/group

user=$(grep ":x:$uid:" /etc/passwd | cut -d: -f1)
chown -Rf $uid:$gid /srv

if [ $# -ne 0 ]; then
    exec gosu $user "$@"
else
	php
fi
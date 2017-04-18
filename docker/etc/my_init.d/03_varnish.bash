#!/usr/bin/env bash
set -e
if [[ ! -f /etc/varnish/default.vcl ]]; then
    echo "init varnish config"
	/var/www/app/console varnish:compile
	/var/www/app/console varnish:create:secret
	/var/www/scripts/varnish_restart.bash
fi

service varnish start
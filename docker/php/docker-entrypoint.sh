#!/usr/bin/env bash

if [ ! -f "$APP/vendor/autoload.php" ]; then
  composer -d "$APP" "${COMPOSER_ENTRYPOINT_SCRIPT:-install}"
fi

unset COMPOSER_ENTRYPOINT_SCRIPT

if [ $# -gt 0 ]; then
  exec "$@"
else
  exec supervisord -c /etc/supervisor/supervisord.conf
fi

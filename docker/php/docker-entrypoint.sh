#!/usr/bin/env bash

composer -d "$APP" "${COMPOSER_ENTRYPOINT_SCRIPT:-install}"

unset COMPOSER_ENTRYPOINT_SCRIPT

if [ $# -gt 0 ]; then
  exec "$@"
else
  exec supervisord -c /etc/supervisor/supervisord.conf
fi

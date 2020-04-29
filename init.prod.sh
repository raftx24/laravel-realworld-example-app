#!/usr/bin/env bash
set -x

role=${CONTAINER_ROLE:-http}

php artisan migrate

if [ "$role" = "http" ]; then
     exec apache2-foreground
elif [ "$role" = "queue" ]; then
    php /var/www/html/artisan queue:listen --daemon
    exit 1
elif [ "$role" = "scheduler" ]; then
     while [ true ]
       do
          echo "Scheduler role"
          php /var/www/html/artisan schedule:run --verbose --no-interaction
          sleep 60
       done
    exit 1
else
    echo "Could not match the container role \"$role\""
    exit 1
fi

apache-2-foreground
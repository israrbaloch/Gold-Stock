#!/bin/bash

# Everyday a new log with dateime is created, so the permissions are changed and need to be updated

# Change permissions and ownership
chmod -R 775 storage
chown -R www-data:www-data storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data bootstrap/cache
chmod 600 .env
chmod -R 775 vendor
chown -R www-data:www-data vendor
chmod -R 755 public
sudo chown -R www-data:www-data storage/logs/